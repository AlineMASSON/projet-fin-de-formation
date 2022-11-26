// == Import
// npm
import PropTypesLib from 'prop-types';
// locaux
import './profilDescription.scss';

// == Composant
function ProfilDescription({ titre, content }) {
  return (
    <div className="profil__description">
      <h2 className="description__title">{titre}</h2>
      <p className="description__info">{content}</p>
    </div>
  );
}

ProfilDescription.propTypes = {
  titre: PropTypesLib.string.isRequired,
  content: PropTypesLib.string.isRequired,
};

// == Export
export default ProfilDescription;
