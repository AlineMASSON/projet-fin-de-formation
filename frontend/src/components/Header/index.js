// == Import
import { Link } from 'react-router-dom';
import PropTypesLib from 'prop-types';

import logo from 'src/assets/logo.svg';
import './header.scss';

// == Composant
function Header({ linkTo }) {
  return (
    <div className="header_div">
      <header className="header">
        <Link className="header__logo" to={linkTo}>
          <img src={logo} alt="logo UpTrain" className="header__logo--picture" />
        </Link>
        <Link to={linkTo}>
          <h1 className="header__title">UpTrain</h1>
        </Link>
      </header>
    </div>
  );
}

Header.propTypes = {
  linkTo: PropTypesLib.string,
};

Header.defaultProps = {
  linkTo: '/triathlete',
};

// == Export
export default Header;
