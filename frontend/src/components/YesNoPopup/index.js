// == Import
// npm
import PropTypesLib from 'prop-types';
import { useDispatch, useSelector } from 'react-redux';
import { useNavigate } from 'react-router-dom';

// locaux
import { togglePopup } from 'src/actions/popup';
import PopupHeader from '../PopupHeader';
import Btn from '../Btn';
import './yesNoPopup.scss';
import { deleteTraining } from '../../actions/trainings';
import { deleteInfosProfil } from '../../actions/profil';
import { logout } from '../../actions/user';
import { getWarningMessage, timeoutWarningMessage } from '../../actions';

// == Composant
function YesNoPopup({ title, answer, textButton }) {
  const dispatch = useDispatch();
  const navigate = useNavigate();

  const isDeleteTraining = useSelector((state) => state.popup.isDeleteTraining);
  const isDeleteProfil = useSelector((state) => state.popup.isDeleteProfil);
  const isTraining = useSelector((state) => state.popup.isTraining);
  const isLogout = useSelector((state) => state.popup.isLogout);

  const handleClickClose = () => {
    if (isDeleteTraining) dispatch(togglePopup('isDeleteTraining', isDeleteTraining));
    if (isDeleteProfil) dispatch(togglePopup('isDeleteProfil', isDeleteProfil));
    if (isLogout) dispatch(togglePopup('isLogout', isLogout));
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    if (isDeleteProfil) dispatch(deleteInfosProfil());
    if (isDeleteTraining) {
      dispatch(deleteTraining());
      dispatch(togglePopup('isTraining', isTraining));
    }
    if (isLogout) {
      dispatch(logout());
      navigate('/');
      dispatch(getWarningMessage('OK', 'Vous êtes déconnecté'));
      setTimeout(() => dispatch(timeoutWarningMessage()), 5000);
    }

    handleClickClose();
  };

  return (
    <div className="yes-no__popup">
      <div className="content">
        <PopupHeader title={title} onClick={handleClickClose} />
        <p className="content__answer">Voulez-vous {answer} ?</p>
        <form action="" method="post" className="content__button" onSubmit={handleSubmit}>
          <Btn type="submit" content={textButton} />
          <Btn type="button" content="Annuler" onClick={handleClickClose} />
        </form>
      </div>
    </div>
  );
}

YesNoPopup.propTypes = {
  title: PropTypesLib.string.isRequired,
  answer: PropTypesLib.string.isRequired,
  textButton: PropTypesLib.string.isRequired,
};

// == Export
export default YesNoPopup;
