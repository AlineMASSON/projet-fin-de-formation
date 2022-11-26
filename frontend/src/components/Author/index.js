// == Import
// npm
import { useSelector } from 'react-redux';

// locaux
import './author.scss';

// == Composant
function Author() {
  const training = useSelector((state) => state.trainings.currentTraining);

  const { user } = training;
  const { firstname, lastname } = user;

  return (
    <div className="popup__training-detail author">
      <p className="popup__value">Crée par {firstname} {lastname}.</p>
    </div>
  );
}

// == Export
export default Author;
