// == Import
// npm
import PropTypesLib from 'prop-types';

// locaux
import './warningMessage.scss';

// == Composant
function WarningMessage({ type, content }) {
  return (
    <div className="warningMessage">
      <p className={type}>{content}</p>
    </div>
  );
}

WarningMessage.propTypes = {
  type: PropTypesLib.string.isRequired,
  content: PropTypesLib.string.isRequired,
};

// == Export
export default WarningMessage;
