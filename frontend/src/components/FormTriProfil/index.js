// == Import
// npm
import { useDispatch, useSelector } from 'react-redux';
import { Link } from 'react-router-dom';
import { editInfosProfil } from 'src/actions/profil';
// locaux
import dateYYYYMMDD from 'src/functions/dateYYYYMMDD';
import NavBar from '../NavBar';
import FieldInput from '../FieldInput';
import FieldSelect from '../FieldSelect';
import FieldTextArea from '../FieldTextArea';
import Btn from '../Btn';
import './formTriProfil.scss';
import { togglePopup } from '../../actions/popup';

// == Composant
function FormTriProfil() {
  const dispatch = useDispatch();
  const infosProfil = useSelector((state) => state.profil.infosProfil);
  const isFormProfil = useSelector((state) => state.popup.isFormProfil);
  const dateBirth = useSelector((state) => state.profil.infosProfil.date_birth);
  console.log(infosProfil);

  const handleCancel = () => {
    dispatch(togglePopup('isFormProfil', isFormProfil));
  };

  const handleClickEdit = () => {
    dispatch(editInfosProfil());
    handleCancel();
  };

  const date = dateBirth !== null ? dateYYYYMMDD(dateBirth) : '';
  return (
    <form action="" method="post" className="edit__triprofil">
      <NavBar />
      <h2 className="triprofil__title">Modifier mon profil</h2>
      <div className="triprofil__fields">
        <div className="left">
          <FieldInput
            type="text"
            name="firstname"
            content="Prénom"
            value={infosProfil.firstname}
            isRequired
          />
          <FieldInput
            type="text"
            name="lastname"
            content="Nom"
            value={infosProfil.lastname}
            isRequired
          />
          <FieldInput
            type="email"
            name="email"
            content="E-mail"
            value={infosProfil.email}
            isRequired
          />
          <FieldInput
            type="text"
            name="city"
            content="Ville"
            value={infosProfil.city === null ? '' : infosProfil.city}
            isRequired
          />
          <FieldSelect
            name="gender"
            content="Genre"
            options={[
              { value: '1', label: 'Homme' },
              { value: '2', label: 'Femme' },
              { value: '3', label: 'Autre' },
            ]}
          />
          <FieldInput
            type="date"
            name="date_birth"
            content="Date de naissance"
            value={date}
            isRequired
          />
          <FieldInput
            type="number"
            name="size"
            content="Taille"
            value={infosProfil.size === null ? '' : infosProfil.size}
            isRequired
          />
          <FieldInput
            type="number"
            name="weight"
            content="Masse"
            value={infosProfil.weight === null ? '' : infosProfil.weight}
            isRequired
          />
        </div>
        <div className="right">
          <FieldTextArea
            name="description"
            content="Description"
            maxLength="1200"
            value={infosProfil.description === null ? '' : infosProfil.description}
          />
          <FieldTextArea
            name="palmares"
            content="Palmarès"
            maxLength="1200"
            value={infosProfil.palmares === null ? '' : infosProfil.palmares}
          />
          <div className="form__buttons">
            <Link to="/triathlete/profil">
              <Btn type="button" content="Annuler les modifications" onClick={handleCancel} />
            </Link>
            <Link to="/triathlete/profil">
              <Btn onClick={handleClickEdit} type="submit" content="Valider les modifications" />
            </Link>
          </div>
        </div>
      </div>
    </form>
  );
}

// == Export
export default FormTriProfil;
