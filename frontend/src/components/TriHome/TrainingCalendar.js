// == Import
// npm
import { useSelector } from 'react-redux';

// locaux
// import trainings from 'src/data/trainings';

import CalendarDay from './CalendarDay';
import './trainingCalendar.scss';

// == Composant
function TrainingCalendar() {
  const week = useSelector((state) => state.trainings.week);

  return (
    <div className="training__calendar">
      {week.map((day) => <CalendarDay key={day} day={day} />)}
    </div>
  );
}

// == Export
export default TrainingCalendar;
