// == Import
// npm
import PropTypesLib from 'prop-types';
import { useDispatch, useSelector } from 'react-redux';
import { changeValue } from 'src/actions';
import { changeValueTraining } from '../../actions/trainings';

// locaux
import './fieldInput.scss';

// == Composant
function FieldInput({
  type,
  name,
  content,
  value,
  placeholder,
  accept,
  isRequired,
  pattern,
}) {
  const dispatch = useDispatch();
  const inputChangeValue = useSelector((state) => state[name]);
  const isFormLogin = useSelector((state) => state.popup.isFormLogin);
  const isFormSignin = useSelector((state) => state.popup.isFormSignin);
  const isFormTraining = useSelector((state) => state.popup.isFormTraining);
  const isFormProfil = useSelector((state) => state.popup.isFormProfil);

  const handleChange = (event) => {
    if (isFormLogin || isFormSignin || isFormProfil) {
      dispatch(changeValue(event.target.name, event.target.value));
    }
    if (isFormTraining) dispatch(changeValueTraining(event.target.name, event.target.value));
  };

  return (
    <div className="field__input">
      <label
        htmlFor={name}
        className={type === 'file' ? 'input__text input-file' : 'input__text'}
      >
        {content}
      </label>
      <input
        placeholder={placeholder === '' ? content : placeholder}
        type={type}
        id={name}
        name={name}
        accept={accept}
        required={isRequired}
        value={value === '' ? inputChangeValue : value}
        onChange={handleChange}
        pattern={pattern}
      />
    </div>
  );
}

FieldInput.propTypes = {
  type: PropTypesLib.string.isRequired,
  name: PropTypesLib.string.isRequired,
  content: PropTypesLib.string.isRequired,
  placeholder: PropTypesLib.string,
  value: PropTypesLib.oneOfType([
    PropTypesLib.string,
    PropTypesLib.number,
    PropTypesLib.bool,
    PropTypesLib.instanceOf(Date),
  ]),
  accept: PropTypesLib.string,
  isRequired: PropTypesLib.bool,
  pattern: PropTypesLib.oneOfType([
    PropTypesLib.string,
    PropTypesLib.bool,
  ]),
};

FieldInput.defaultProps = {
  placeholder: '',
  value: '',
  accept: '',
  isRequired: false,
  pattern: false,
};

// == Export
export default FieldInput;
