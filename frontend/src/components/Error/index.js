// == Import
// npm
import { Link } from 'react-router-dom';

// locaux
import logo from 'src/assets/logo.svg';
import './error.scss';

// == Composant
function Error() {
  return (
    <div className="not-found__error">
      <h1 className="error__title">4 <img src={logo} alt="logo UpTrain" className="error__title--logo" /> 4</h1>
      <p className="error__content">On dirait que vous n'avez pas suivi le tracé de la course. Si vous continuez sur cette voie, vous allez être disqualifié.</p>
      <p className="error__content">Vous devez malheureusement recommencer votre course et retourner sur <Link className="link" to="/">la ligne de départ !</Link></p>
    </div>
  );
}

// == Export
export default Error;
