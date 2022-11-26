// == Import
// npm
import PropTypesLib from 'prop-types';
import { useDispatch, useSelector } from 'react-redux';

// locaux
import { changeValue } from 'src/actions';
import { changeValueTraining } from '../../actions/trainings';
import './fieldSelect.scss';

// == Composant
function FieldSelect({
  name,
  content,
  options,
  value,
  isRequired,
}) {
  const dispatch = useDispatch();
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
    <div className="field__select">
      <label className="select__text" htmlFor={name}>{content}</label>
      <select name={name} id={name} onChange={handleChange} required={isRequired}>
        <option value="" selected={value === ''} disabled>{content}</option>
        {
          options.map((option) => (
            <option
              key={option.value}
              value={option.value}
              selected={value === option.value}
            >
              {option.label}
            </option>
          ))
        }
      </select>
    </div>
  );
}

FieldSelect.propTypes = {
  name: PropTypesLib.string.isRequired,
  content: PropTypesLib.string.isRequired,
  isRequired: PropTypesLib.bool.isRequired,
  options: PropTypesLib.arrayOf(
    PropTypesLib.shape({
      value: PropTypesLib.string.isRequired,
      label: PropTypesLib.string.isRequired,
    }),
  ).isRequired,
  value: PropTypesLib.oneOfType([
    PropTypesLib.string,
    PropTypesLib.number,
    PropTypesLib.bool,
  ]),

};
FieldSelect.defaultProps = {
  value: '',
};

// == Export
export default FieldSelect;
