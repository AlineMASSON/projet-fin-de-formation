// == Import
// npm
import PropTypesLib from 'prop-types';
import { Link } from 'react-router-dom';
import { useDispatch, useSelector } from 'react-redux';

// locaux
import { togglePopup } from 'src/actions/popup';
import sportsData from 'src/data/sports';
import './daySession.scss';
import { getCurrentTrainingId } from '../../actions/trainings';

// == Composant
function DaySession({
  title,
  sport,
  id,
  isValidated,
}) {
  const dispatch = useDispatch();

  const isTraining = useSelector((state) => state.popup.isTraining);

  const handleClickTraining = (event) => {
    event.preventDefault();
    dispatch(getCurrentTrainingId(id));
    dispatch(togglePopup('isTraining', isTraining));
  };

  const sports = sportsData.filter((sportData) => sportData.name === sport);
  const { src: sportSrc, id: sportId } = sports[0];
  return (
    <div className="session">
      <Link className={isValidated ? 'day__session' : `day__session ${sportId}`} onClick={handleClickTraining}>
        <img className="session__logo" src={sportSrc} alt={sport} />
        <p className="session__title">{title}</p>
      </Link>
    </div>
  );
}

DaySession.propTypes = {
  title: PropTypesLib.string.isRequired,
  sport: PropTypesLib.string.isRequired,
  id: PropTypesLib.number.isRequired,
  isValidated: PropTypesLib.bool.isRequired,
};

// == Export
export default DaySession;
