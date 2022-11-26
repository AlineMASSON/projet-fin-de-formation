// == Import
// npm
import PropTypesLib from 'prop-types';
// locaux
import './trainingDetail.scss';

// == Composant
function TrainingDetail({ label, value, PPG }) {
  return (
    <div className="training__detail">
      <p className="popup__label">{label}</p>
      <p className="popup__value">{value}</p>
      {PPG ? <p className="popup__value">PPG</p> : ''}
    </div>
  );
}

TrainingDetail.propTypes = {
  label: PropTypesLib.string.isRequired,
  value: PropTypesLib.oneOfType([
    PropTypesLib.string,
    PropTypesLib.number,
    PropTypesLib.bool,
  ]),
  PPG: PropTypesLib.bool,
};

TrainingDetail.defaultProps = {
  PPG: false,
  value: '',
};

// == Export
export default TrainingDetail;
