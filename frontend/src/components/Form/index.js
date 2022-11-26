// == Import
// npm
import PropTypesLib from 'prop-types';
import { useDispatch } from 'react-redux';
import { login } from 'src/actions/user';

// locaux
import FormSignin from '../FormSignin';
import FormTraining from '../FormTraining';
import FormTriProfil from '../FormTriProfil';
import './form.scss';

// == Composant
function Form({ formSignin, formTriProfil, formTraining }) {
  const dispatch = useDispatch();

  const handleSubmit = (event) => {
    event.preventDefault();
    dispatch(login());
  };

  return (
    <form action="" method="post" className="forms" onSubmit={handleSubmit}>
      {formSignin && <FormSignin />}
      {formTriProfil && <FormTriProfil />}
      {formTraining && <FormTraining />}
    </form>
  );
}

Form.propTypes = {
  formSignin: PropTypesLib.bool,
  formTriProfil: PropTypesLib.bool,
  formTraining: PropTypesLib.bool,

};

Form.defaultProps = {
  formSignin: false,
  formTriProfil: false,
  formTraining: false,
};

// == Export
export default Form;
