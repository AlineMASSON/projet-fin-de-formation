// == Import
// npm
import PropTypesLib from 'prop-types';
import { useDispatch, useSelector } from 'react-redux';
// locaux
import { changeValue } from 'src/actions';
import { changeValueTraining } from '../../actions/trainings';
import './fieldTextArea.scss';

// == Composant
function FieldTextArea({
  name,
  content,
  maxLength,
  placeholder,
  value,
  isRequired,
}) {
  const dispatch = useDispatch();
  const inputChangeValue = useSelector((state) => state[name]);
  const isFormProfil = useSelector((state) => state.popup.isFormProfil);
  const isFormTraining = useSelector((state) => state.popup.isFormTraining);
  const isFormIsValidated = useSelector((state) => state.popup.isFormIsValidated);

  const handleChange = (event) => {
    if (isFormProfil) dispatch(changeValue(event.target.name, event.target.value));
    if (isFormTraining || isFormIsValidated) {
      dispatch(changeValueTraining(event.target.name, event.target.value));
    }
  };
  return (
    <div className="field__textarea">
      <label className="textarea__text" htmlFor={name}>{content}</label>
      <textarea
        placeholder={placeholder === '' ? content : placeholder}
        id={name}
        name={name}
        maxLength={maxLength}
        onChange={handleChange}
        value={value === '' ? inputChangeValue : value}
        required={isRequired}
      />
    </div>
  );
}

FieldTextArea.propTypes = {
  name: PropTypesLib.string.isRequired,
  content: PropTypesLib.string.isRequired,
  maxLength: PropTypesLib.string.isRequired,
  placeholder: PropTypesLib.string,
  value: PropTypesLib.string,
  isRequired: PropTypesLib.bool,
};

FieldTextArea.defaultProps = {
  placeholder: '',
  value: '',
  isRequired: false,
};

// == Export
export default FieldTextArea;
