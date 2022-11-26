// == Import
// npm
import { useDispatch, useSelector } from 'react-redux';
import { togglePopup } from 'src/actions/popup';

// locaux
import dateYYYYMMDD from 'src/functions/dateYYYYMMDD';
import FieldSelect from 'src/components/FieldSelect';
import FieldTextArea from 'src/components/FieldTextArea';
import trainingLabel from 'src/data/trainingLabel';
import { closeTraining, saveEditTraining, SaveReview } from '../../actions/trainings';
import PopupHeader from '../PopupHeader';
import Btn from '../Btn';
import './formIsValidated.scss';

// == Composant
function FormIsValidated() {
  const dispatch = useDispatch();
  const training = useSelector((state) => state.trainings.currentTraining);
  const isFormIsValidated = useSelector((state) => state.popup.isFormIsValidated);
  const isTraining = useSelector((state) => state.popup.isTraining);

  const feeling = trainingLabel.filter(((label) => label.bdd === 'feeling'));

  const handleClickClose = () => {
    dispatch(togglePopup('isFormIsValidated', isFormIsValidated));
  };

  const handleSubmitIsValidated = (event) => {
    event.preventDefault();
    dispatch(togglePopup('isTraining', isTraining));
    dispatch(togglePopup('isFormIsValidated', isFormIsValidated));
    dispatch(saveEditTraining());
    dispatch(SaveReview());
    dispatch(closeTraining());
  };

  const options = {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  };

  const dayToString = new Date(dateYYYYMMDD(training.date)).toLocaleDateString('fr-FR', options);

  return (
    <form action="" method="post" className="popup__formIsValidated" onSubmit={handleSubmitIsValidated}>
      <PopupHeader
        title={`Valider l'entraînement ${training.title} du ${dayToString}`}
        onClick={handleClickClose}
      />
      <FieldSelect
        key={feeling[0].bdd}
        name={feeling[0].bdd}
        content={feeling[0].content}
        isRequired={feeling[0].isRequired}
        options={feeling[0].options}
      />
      <FieldTextArea
        name="addReview"
        content="Ajouter un commentaire sur votre séance"
        maxLength="1200"
        placeholder="Décrivez si necessaire les ressentis lors de votre séance"
      />
      <div className="formIsValidated__buttons">
        <Btn type="submit" content="Valider l'entraînement" />
      </div>
    </form>
  );
}

// == Export
export default FormIsValidated;
