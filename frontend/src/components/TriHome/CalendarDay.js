// == Import
// npm
import PropTypesLib from 'prop-types';
import { useSelector } from 'react-redux';

import DaySession from './DaySession';

// locaux
import './calendarDay.scss';
// import DaySession from './DaySession';

// == Composant
function CalendarDay({ day }) {
  const trainings = useSelector((state) => state.trainings.allTrainings);

  const options = { weekday: 'long', month: 'long', day: 'numeric' };
  const dayToString = day.toLocaleDateString('fr-FR', options);
  const date = day.toLocaleDateString().replaceAll('/', '-');

  const sessions = trainings.filter((training) => training.date === date);

  return (
    <div className="calendar__day">
      <h3 className="day__title">{dayToString}</h3>
      {
        sessions.map((session) => <DaySession key={session.id} {...session} />)
      }
    </div>
  );
}

CalendarDay.propTypes = {
  day: PropTypesLib.instanceOf(Date).isRequired,
};
// == Export
export default CalendarDay;
