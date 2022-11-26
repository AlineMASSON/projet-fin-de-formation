// == Import
// npm
import { useDispatch, useSelector } from 'react-redux';
import { Link } from 'react-router-dom';

// locaux
import github from 'src/assets/icon/github.svg';
import facebook from 'src/assets/icon/facebook.svg';
import twitter from 'src/assets/icon/twitter.svg';
import training from 'src/assets/Home/training.png';
import detail from 'src/assets/Home/detail.png';
import { togglePopup } from '../../actions/popup';
import Btn from '../Btn';
import Header from '../Header';
import Popup from '../Popup';
import WarningMessage from '../WarningMessage/WarningMessage';
import './home.scss';

// == Composant
function Home() {
  const dispatch = useDispatch();
  const isFormLogin = useSelector((state) => state.popup.isFormLogin);
  const isFormSignin = useSelector((state) => state.popup.isFormSignin);
  const warningMessage = useSelector((state) => state.user.warningMessage);

  const handleClickSignin = () => {
    dispatch(togglePopup('isFormSignin', isFormSignin));
  };
  const handleClickLogin = () => {
    dispatch(togglePopup('isFormLogin', isFormLogin));
  };
  return (
    <div className="home">
      {
        warningMessage.warning
        && <WarningMessage type={warningMessage.status} content={warningMessage.message} />
      }
      <Header linkTo="/" />
      <div className="home__presentation">
        <div className="home__pictures">
          <img src={training} alt="screenshot de l'application : calendrier" className="pictures__training pictures" />
          <img src={detail} alt="screenshot de l'application : ajouter un entraînement" className="pictures__detail pictures" />
        </div>
        <div className="presentation">
          <p className="presentation__text">Partenaire de ton entraînement !</p>
        </div>
      </div>
      <div className="home__buttons">
        <Btn type="button" content="S'inscrire" onClick={handleClickSignin} />
        <Btn type="button" content="Se connecter" onClick={handleClickLogin} />
      </div>
      <footer className="home__footer">
        <a href="#"><img src={github} alt="logo Facebook" className="footer__logo" /></a>
        <a href="#"><img src={twitter} alt="logo Instagram" className="footer__logo" /></a>
        <a href="#"><img src={facebook} alt="logo Twitter" className="footer__logo" /></a>
        <a href="#" className="footer__link link">Contact</a>
        <Link className="footer__link link" to="/mentions-legales">Mentions légales</Link>
      </footer>

      { isFormLogin && <Popup formLogin /> }
      { isFormSignin && <Popup formSignin /> }
    </div>
  );
}

// == Export
export default Home;
