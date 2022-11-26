// === Import
import { TOGGLE_POPUP } from '../actions/popup';

// === State
const initialState = {
  isFormLogin: false,
  isFormSignin: false,
  isFormTraining: false,
  isTraining: false,
  isFormProfil: false,
  isFormIsValidated: false,
  isDeleteProfil: false,
  isDeleteTraining: false,
  isLogout: false,
};

// === Reducer
function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case TOGGLE_POPUP:
      return {
        ...state,
        [action.key]: !action.value,
      };
    default:
      return state;
  }
}

// === Export
export default reducer;
