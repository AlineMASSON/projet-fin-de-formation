// == Import
// npm
import PropTypesLib from 'prop-types';
// locaux
import biker from 'src/assets/avatar/biker.svg';
import bikeuse from 'src/assets/avatar/bikeuse.svg';
import joggeur from 'src/assets/avatar/joggeur.svg';
import joggeuse from 'src/assets/avatar/joggeuse.svg';
import nageur from 'src/assets/avatar/nageur.svg';
import nageuse from 'src/assets/avatar/nageuse.svg';
import user from 'src/assets/avatar/user.svg';

// import dateYYYYMMDD from 'src/functions/dateYYYYMMDD';
import dateFormat from '../../functions/dateFormat';
import './profilInfos.scss';

// == Composant
function ProfilInfos({
  weight,
  size,
  picture,
  firstname,
  lastname,
  email,
  city,
  gender,
  // eslint-disable-next-line camelcase
  date_birth,
}) {
  const AgeCalcul = () => {
    const date = dateFormat(date_birth);
    const today = new Date();
    let age = today.getFullYear() - date.getFullYear();
    const m = today.getMonth() - date.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < date.getDate())) {
      age -= 1;
    }
    return age;
  };

  let img = '';
  if (picture === 'src/assets/avatar/biker.svg') {
    img = biker;
  }
  else if (picture === 'src/assets/avatar/bikeuse.svg') {
    img = bikeuse;
  }
  else if (picture === 'src/assets/avatar/joggeur.svg') {
    img = joggeur;
  }
  else if (picture === 'src/assets/avatar/joggeuse.svg') {
    img = joggeuse;
  }
  else if (picture === 'src/assets/avatar/nageur.svg') {
    img = nageur;
  }
  else if (picture === 'src/assets/avatar/nageuse.svg') {
    img = nageuse;
  }
  else {
    img = user;
  }

  return (
    <div className="profil__infos">
      <div className="description">
        <div className="description__picture">
          <img src={img} alt="Profil" className="picture--avatar-tri" />
        </div>
        <h2 className="description__title">{firstname} {lastname}</h2>
      </div>
      <p className="description__info">{email}</p>
      <p className="description__info">{city}</p>
      <p className="description__info">{gender !== null ? ((gender === 1 && 'Homme') || (gender === 2 && 'Femme') || (gender === 9 && 'Autre')) : ''}</p>
      <p className="description__info">{date_birth !== null ? `${AgeCalcul()} ans` : ''}</p>
      <p className="description__info">{size !== null ? `${size} cm` : ''}</p>
      <p className="description__info">{weight !== null ? `${weight} kg` : ''}</p>
    </div>
  );
}

ProfilInfos.propTypes = {
  weight: PropTypesLib.string,
  size: PropTypesLib.string,
  picture: PropTypesLib.string.isRequired,
  firstname: PropTypesLib.string.isRequired,
  lastname: PropTypesLib.string.isRequired,
  email: PropTypesLib.string.isRequired,
  city: PropTypesLib.string,
  gender: PropTypesLib.string,
  date_birth: PropTypesLib.string,
};

ProfilInfos.defaultProps = {
  weight: '',
  size: '',
  city: '',
  gender: '',
  date_birth: '',
};
// == Export
export default ProfilInfos;
