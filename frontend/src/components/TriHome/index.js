// == Import
import { useDispatch, useSelector } from 'react-redux';
import { useEffect } from 'react';

import dateYYYYMMDD from 'src/functions/dateYYYYMMDD';
import WarningMessage from 'src/components/WarningMessage/WarningMessage';
import YesNoPopup from 'src/components/YesNoPopup';
import add from 'src/assets/icon/add.svg';
import {
  formTraining,
  getDatas,
  switchDay,
} from '../../actions/trainings';
import Btn from '../Btn';
import NavBar from '../NavBar';
import Popup from '../Popup';
import TrainingCalendar from './TrainingCalendar';
import Loading from '../Loading';
import { togglePopup } from '../../actions/popup';
import { connectUser } from '../../actions/user';
import './triHome.scss';

// == Composant
function TriHome() {
  const dispatch = useDispatch();

  useEffect(() => {
    dispatch(connectUser(
      localStorage.getItem('firstname'),
      localStorage.getItem('userId'),
      localStorage.getItem('triathleteId'),
      localStorage.getItem('token'),
    ));
    dispatch(getDatas());
  }, []);

  const firstname = useSelector((state) => state.user.firstname);
  const week = useSelector((state) => state.trainings.week);
  const training = useSelector((state) => state.trainings.currentTraining);
  const loading = useSelector((state) => state.trainings.loadingAllTrainings);
  const isPost = useSelector((state) => state.trainings.isPost);
  const countSwitchDay = useSelector((state) => state.trainings.countSwitchDay);
  const isTraining = useSelector((state) => state.popup.isTraining);
  const isDeleteTraining = useSelector((state) => state.popup.isDeleteTraining);
  const isFormIsValidated = useSelector((state) => state.popup.isFormIsValidated);
  const isFormTraining = useSelector((state) => state.popup.isFormTraining);
  const warningMessage = useSelector((state) => state.user.warningMessage);

  const firstDay = week[0].toLocaleDateString();
  const lastDay = week[6].toLocaleDateString();

  const handleClickAddTraining = () => {
    dispatch(togglePopup('isFormTraining', isFormTraining));
    dispatch(formTraining('isPost', isPost));
  };

  const handleClickPrevious = () => {
    dispatch(switchDay(countSwitchDay - 1));
  };

  const handleClickNext = () => {
    dispatch(switchDay(countSwitchDay + 1));
  };

  const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };

  const dayToString = isDeleteTraining && new Date(dateYYYYMMDD(training.date)).toLocaleDateString('fr-FR', options);

  return (
    <div className="trihome">
      {loading && <Loading />}
      {!loading && (
        <>
          <NavBar />
          <h2 className="trihome__title">Bienvenue <span>{firstname}</span> dans ton espace personnel</h2>
          <div className="trihome__training">
            <div className="training__header">
              <h3 className="header__week">Semaine du {firstDay} au {lastDay}</h3>
              { warningMessage.warning
              && <WarningMessage type={warningMessage.status} content={warningMessage.message} />}
              <div className="desktop header__button">
                <Btn type="button" content="Ajouter un entraînement" onClick={handleClickAddTraining} />
              </div>
              <div className="phone header__button">
                <Btn type="button" content="Ajouter un entraînement" src={add} onClick={handleClickAddTraining} />
              </div>
            </div>
            <TrainingCalendar />
            <div className="training__change btn desktop">
              <Btn type="button" content="&#60;" onClick={handleClickPrevious} />
              <Btn type="button" content="&#62;" onClick={handleClickNext} />
            </div>
          </div>
          {isTraining && <Popup training />}
          {isFormIsValidated && <Popup formIsValidated />}
          {isDeleteTraining && (
            <YesNoPopup
              title={'Suppression d\'un entraînement'}
              answer={`supprimer l'entraînement ${training.title} du ${dayToString}`}
              textButton={'Oui, supprimer l\'entraînement'}
            />
          )}
          {isFormTraining && <Popup formTraining />}
        </>
      )}
    </div>
  );
}

// == Export
export default TriHome;
