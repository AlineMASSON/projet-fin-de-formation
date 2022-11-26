// == Import
// npm
import { Link } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';
import dateYYYYMMDD from 'src/functions/dateYYYYMMDD';
import { togglePopup } from 'src/actions/popup';
import Toggle from 'react-toggle';
import 'react-toggle/style.css';
import '../ReactToggle/reactToggleCustom.scss';

import modify from 'src/assets/icon/modify.svg';
import del from 'src/assets/icon/delete.svg';
import {
  closeTraining,
  editTraining,
  formTraining,
  changeValueTraining,
} from '../../actions/trainings';
import Btn from '../Btn';
import PopupHeader from '../PopupHeader';
import TrainingDetail from '../TrainingDetail';
import trainingLabel from '../../data/trainingLabel';
import Author from '../Author';
import Loading from '../Loading';
import './training.scss';
import { getWarningMessage, timeoutWarningMessage } from '../../actions';

// == Composant
function Training() {
  const dispatch = useDispatch();
  const loading = useSelector((state) => state.trainings.loadingCurrentTraining);
  const isTraining = useSelector((state) => state.popup.isTraining);
  const training = useSelector((state) => state.trainings.currentTraining);
  const reviews = useSelector((state) => state.trainings.currentTraining.reviews);
  const isDeleteTraining = useSelector((state) => state.popup.isDeleteTraining);
  const isFormIsValidated = useSelector((state) => state.popup.isFormIsValidated);
  const isFormTraining = useSelector((state) => state.popup.isFormTraining);
  const isPatch = useSelector((state) => state.trainings.isPatch);

  // récuperation des keys de l'objet training
  const keysTraining = Object.keys(training);

  const handleClickClose = () => {
    dispatch(togglePopup('isTraining', isTraining));
    dispatch(closeTraining());
  };

  const handleTrainingCheck = (event) => {
    dispatch(togglePopup('isFormIsValidated', isFormIsValidated));
    dispatch(changeValueTraining(event.target.name, event.target.checked));
  };

  const handleTrainingDelete = () => {
    dispatch(togglePopup('isDeleteTraining', isDeleteTraining));
  };

  const handleTrainingPatch = () => {
    dispatch(togglePopup('isFormTraining', isFormTraining));
    dispatch(togglePopup('isTraining', isTraining));
    dispatch(formTraining('isPatch', isPatch));
    dispatch(editTraining());
  };

  const handleClickEdit = () => {
    dispatch(getWarningMessage('Forbidden', 'Cet entrainement est déjà effectué, vous ne pouvez pas le modifier.'));
    handleClickClose();
    setTimeout(() => dispatch(timeoutWarningMessage()), 5000);
  };

  const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };

  const dayToString = !loading && new Date(dateYYYYMMDD(training.date)).toLocaleDateString('fr-FR', options);

  return (
    <div className="popup__training">
      {loading && <Loading />}
      {!loading && (
        <>
          <PopupHeader title={`Entraînement du ${dayToString}`} onClick={handleClickClose} />
          <div className="popup__definition-training">
            {
              keysTraining.map((key) => {
                // récupération de l'objet dans trainingLabel correspondant à la clé de training
                const currentLabel = trainingLabel.filter((label) => label.bdd === key);
                // utilisation des [] à la place du .
                // pour pouvoir recherche dans un objet avec une string
                // si la key est non présente dans l'objet, renvoie undefined
                if (currentLabel.length === 1 && training[key] !== '' && key !== 'isPpg' && key !== 'isValidated' && key !== 'isPpg') {
                  return (
                    <TrainingDetail
                      key={key}
                      label={currentLabel[0].content}
                      value={training[key]}
                    />
                  );
                }

                if (key === 'isPpg') {
                  return (
                    <label htmlFor={key} className="toggle">
                      <Toggle
                        key={key}
                        icons={false}
                        name={key}
                        id={key}
                        checked={training[key]}
                      />
                      <p className="toggle__content">{currentLabel[0].content}</p>
                    </label>
                  );
                }

                if (key === 'isValidated') {
                  return (
                    <label htmlFor={key} className="toggle">
                      {training[key] && (
                        <Toggle
                          key={key}
                          icons={false}
                          name={key}
                          id={key}
                          checked={training[key]}
                        />
                      ) }
                      {!training[key] && (
                        <Toggle
                          key={key}
                          icons={false}
                          name={key}
                          id={key}
                          defaultChecked={training[key]}
                          onChange={handleTrainingCheck}
                        />
                      ) }
                      <p className="toggle__content">{currentLabel[0].content}</p>
                    </label>
                  );
                }
                return;
              })
            }
          </div>

          {training.isValidated && (
            <div className="popup__training-check">
              {
                reviews !== undefined
                && reviews.map((review) => {
                  const userReview = review.user;
                  return (<TrainingDetail label={`Commentaire de ${userReview.firstname} ${userReview.lastname}`} value={review.content} />);
                })
              }
            </div>
          )}
          <Author />
          <div className="popup__buttons">
            <Btn type="button" content="Icone supprimer" src={del} onClick={handleTrainingDelete} />
            <Btn type="button" content="Icone modifier" src={modify} onClick={training.isValidated ? handleClickEdit : handleTrainingPatch} />
          </div>
        </>
      )}
    </div>
  );
}

// == Export
export default Training;
