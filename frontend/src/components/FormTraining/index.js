// == Import
// npm
import { useDispatch, useSelector } from 'react-redux';
import { togglePopup } from 'src/actions/popup';

// locaux
import dateYYYYMMDD from 'src/functions/dateYYYYMMDD';
import trainingLabel from 'src/data/trainingLabel';
import inputGenerator from 'src/functions/inputGenerator';
import {
  addNewTraining,
  closeTraining,
  formTraining,
  getDatas,
  saveEditTraining,
} from '../../actions/trainings';
import Btn from '../Btn';
import PopupHeader from '../PopupHeader';
import './formTraining.scss';

// == Composant
function FormTraining() {
  const dispatch = useDispatch();
  const isFormTraining = useSelector((state) => state.popup.isFormTraining);
  const training = useSelector((state) => state.trainings.currentTraining);
  const isPost = useSelector((state) => state.trainings.isPost);
  const isPatch = useSelector((state) => state.trainings.isPatch);

  const handleClickClose = () => {
    dispatch(togglePopup('isFormTraining', isFormTraining));
    if (isPost) dispatch(formTraining('isPost', isPost));
    if (isPatch) dispatch(formTraining('isPatch', isPatch));
    dispatch(closeTraining());
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    dispatch(togglePopup('isFormTraining', isFormTraining));
    if (isPost) {
      dispatch(addNewTraining());
      dispatch(formTraining('isPost', isPost));
    }
    if (isPatch) {
      dispatch(formTraining('isPatch', isPatch));
      dispatch(saveEditTraining());
    }
    dispatch(closeTraining());
    dispatch(getDatas());
  };

  const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };

  const dayToString = isPatch && new Date(dateYYYYMMDD(training.date)).toLocaleDateString('fr-FR', options);

  return (
    <form action="" method="post" className="popup__training" onSubmit={handleSubmit}>
      <PopupHeader
        title={isPatch ? `Modifier l'entraînement du ${dayToString} ` : 'Ajouter un entraînement'}
        onClick={handleClickClose}
      />
      { isPost && trainingLabel.map((label) => label.addTrainng && inputGenerator(label)) }
      { isPatch && training.isValidated && trainingLabel.map((label) => inputGenerator(label)) }
      { isPatch && !training.isValidated && (
        trainingLabel.map((label) => label.editTraining && inputGenerator(label))
      )}
      <div className="popup__buttons">
        <Btn type="submit" content={isPatch ? 'Valider les modifications' : 'Ajouter l\'entraînement'} />
      </div>
    </form>
  );
}

// == Export
export default FormTraining;
