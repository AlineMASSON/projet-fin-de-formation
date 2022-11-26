// == Import
// npm
import { Link } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';

// locaux
import avatar from 'src/assets/icon/avatar.svg';
import logout from 'src/assets/icon/logout.svg';
import Header from '../Header';
import YesNoPopup from '../YesNoPopup';
import { togglePopup } from '../../actions/popup';
import './navbar.scss';

// == Composant
function NavBar() {
  const dispatch = useDispatch();
  const isLogout = useSelector((state) => state.popup.isLogout);

  const handleLogout = () => {
    dispatch(togglePopup('isLogout', isLogout));
  };

  return (
    <nav className="navbar">
      <Header />
      <div className="navbar__links">
        <div className="links__left">
          <Link className="left__link desktop link" to="/triathlete">Accueil</Link>
          <Link className="left__link desktop link" to="/triathlete/profil">Profil</Link>
          <Link className="left__link phone link" to="/triathlete/profil">
            <img className="link__icon" src={avatar} alt="Icône profil" />
          </Link>
        </div>
        <Link className="links__right link desktop" onClick={handleLogout}>Se déconnecter</Link>
        <Link className="left__link phone link" onClick={handleLogout}>
          <img className="link__icon" src={logout} alt="Icône se déconnecter" />
        </Link>
      </div>
      {isLogout && <YesNoPopup title="Déconnexion" answer="vous déconnecter" textButton="Se déconnecter" />}
    </nav>
  );
}

// == Export
export default NavBar;
