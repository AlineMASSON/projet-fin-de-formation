// == Import
// npm
import { useDispatch, useSelector } from 'react-redux';
import { login } from 'src/actions/user';
import { togglePopup } from 'src/actions/popup';
// locaux
import PopupHeader from '../PopupHeader';
import FieldInput from '../FieldInput';
import Btn from '../Btn';
import './loginPopup.scss';
import WarningMessage from '../WarningMessage/WarningMessage';

// == Composant
function LoginPopup() {
  const dispatch = useDispatch();

  const isFormLogin = useSelector((state) => state.popup.isFormLogin);
  const errorMessage = useSelector((state) => state.user.errorMessage);

  const handleSubmit = (event) => {
    event.preventDefault();
    dispatch(login());
  };

  const handleClickClose = () => {
    dispatch(togglePopup('isFormLogin', isFormLogin));
  };

  return (
    <form action="" method="post" className="login__popup" onSubmit={handleSubmit}>
      <PopupHeader title="Connexion" onClick={handleClickClose} />
      <FieldInput type="email" name="username" content="E-mail" isRequired />
      <FieldInput type="password" name="password" content="Mot de passe" isRequired />
      { errorMessage && <WarningMessage type="error" content="Votre email et/ou mot de passe est incorrecte." />}
      <div className="login__button">
        <Btn type="submit" content="Se connecter" />
      </div>
    </form>
  );
}

// == Export
export default LoginPopup;
