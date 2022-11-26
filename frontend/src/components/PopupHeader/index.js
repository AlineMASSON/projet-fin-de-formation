// == Import
// npm
import PropTypesLib from 'prop-types';
import { Link } from 'react-router-dom';
// locaux
import close from 'src/assets/icon/close.svg';
import Btn from '../Btn';
import './popupHeader.scss';

// == Composant
function PopupHeader({ title, onClick }) {
  return (
    <div className="popup__header">
      <Btn type="button" content="icon-close" src={close} onClick={onClick} />
      <h2 className="popup__title">{title}</h2>
    </div>
  );
}

PopupHeader.propTypes = {
  title: PropTypesLib.string.isRequired,
  onClick: PropTypesLib.func.isRequired,
};

// == Export
export default PopupHeader;
