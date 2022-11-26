// == Import
// npm
import { useDispatch, useSelector } from 'react-redux';
import { Link } from 'react-router-dom';
// locaux
import WarningMessage from 'src/components/WarningMessage/WarningMessage';
import modify from 'src/assets/icon/modify.svg';
import del from 'src/assets/icon/delete.svg';
import ProfilInfos from 'src/components/ProfilInfos';
import ProfilDescription from '../ProfilDescription';
import NavBar from '../NavBar';
import Btn from '../Btn';
import YesNoPopup from '../YesNoPopup';
import { togglePopup } from '../../actions/popup';
import './triprofil.scss';

// == Composant
function TriProfil() {
  const dispatch = useDispatch();
  const profil = useSelector((state) => state.profil.infosProfil);
  const isDeleteProfil = useSelector((state) => state.popup.isDeleteProfil);
  const isFormProfil = useSelector((state) => state.popup.isFormProfil);
  const warningMessage = useSelector((state) => state.user.warningMessage);

  const handleClick = () => {
    dispatch(togglePopup('isDeleteProfil', isDeleteProfil));
  };
  const handleClickEdit = () => {
    dispatch(togglePopup('isFormProfil', isFormProfil));
  };

  return (
    <div className="triprofil">
      <NavBar />
      { warningMessage.warning
        && <WarningMessage type={warningMessage.status} content={warningMessage.message} />}
      <div className="profil">
        <div className="profil__description infos">
          <ProfilInfos {...profil} />
        </div>
        <ProfilDescription titre="Palmarès" content={profil.palmares} />
        <ProfilDescription titre="Description" content={profil.description} />
        <div className="buttons">
          <Link onClick={handleClick}>
            <Btn type="button" content="Icone supprimer" src={del} />
          </Link>
          <Link to="/triathlete/profil/modifier" onClick={handleClickEdit}>
            <Btn type="button" content="Icone modifier" src={modify} />
          </Link>
        </div>
        {isDeleteProfil && <YesNoPopup title="Suppression de mon profil" answer="supprimer votre profil" textButton="Supprimer le profil" />}
      </div>
    </div>
  );
}

// == Export
export default TriProfil;
