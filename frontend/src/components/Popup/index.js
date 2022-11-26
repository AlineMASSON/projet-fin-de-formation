// == Import
// npm
import PropTypesLib from 'prop-types';
// locaux
import LoginPopup from '../LoginPopup';
import Training from '../Training';
import FormSignin from '../FormSignin';
import FormTraining from '../FormTraining';
import FormIsValidated from '../FormIsValidated';
import './popup.scss';

// == Composant
function Popup({
  formLogin,
  training,
  formSignin,
  formTraining,
  formIsValidated,
}) {
  return (
    <div className="popup">
      {formLogin && <LoginPopup />}
      {training && <Training />}
      {formSignin && <FormSignin />}
      {formTraining && <FormTraining />}
      {formIsValidated && <FormIsValidated />}
    </div>
  );
}

Popup.propTypes = {
  formLogin: PropTypesLib.bool,
  training: PropTypesLib.bool,
  formSignin: PropTypesLib.bool,
  formTraining: PropTypesLib.bool,
  formIsValidated: PropTypesLib.bool,
};

Popup.defaultProps = {
  formLogin: false,
  training: false,
  formSignin: false,
  formTraining: false,
  formIsValidated: false,
};

// == Export
export default Popup;
