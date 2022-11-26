// == Import
import { Route, Routes } from 'react-router-dom';

import FormTriProfil from '../FormTriProfil';
import Home from '../Home';
import TriHome from '../TriHome';
import TriProfil from '../TriProfil';
import Training from '../Training';
import YesNoPopup from '../YesNoPopup';
import './upTrain.scss';
import Error from '../Error';
import Legals from '../Legals';

// == Composant
function UpTrain() {
  return (

    <div className="uptrain dark">
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/mentions-legales" element={<Legals />} />
        <Route path="/triathlete" element={<TriHome />} />
        <Route path="/triathlete/profil" element={<TriProfil />} />
        <Route path="/triathlete/profil/modifier" element={<FormTriProfil />} />
        <Route path="/triathlete/profil/supprimer" element={<YesNoPopup title="Suppression de mon profil" answer="supprimer votre profil" textButton="Supprimer mon profil" />} />
        <Route path="/triathlete/training" element={<Training />} />
        <Route path="*" element={<Error />} />
      </Routes>

      {/* <Popup loginPopup /> */}
    </div>
  );
}

// == Export
export default UpTrain;
