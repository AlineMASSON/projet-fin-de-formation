// == Import
// npm
import PropTypesLib from 'prop-types';

// locaux
import './btn.scss';

// == Composant
function Btn({
  type,
  content,
  src,
  onClick,
}) {
  return (
    <button onClick={onClick} type={type} className="btn">
      { src === '' ? content : <img src={src} alt={content} className="icon" /> }
    </button>
  );
}

Btn.propTypes = {
  type: PropTypesLib.string.isRequired,
  content: PropTypesLib.string.isRequired,
  src: PropTypesLib.string,
  onClick: PropTypesLib.func,
};

Btn.defaultProps = {
  src: '',
  onClick: console.log(),
};

// == Export
export default Btn;
