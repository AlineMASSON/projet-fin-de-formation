// === Import
import { CHANGE_VALUE, GET_WARNING_MESSAGE, TIMEOUT_WARNING_MESSAGE } from '../actions';
import { CONNECT_USER, LOGIN_ERROR, LOGOUT } from '../actions/user';

// === State
const initialState = {
  errorMessage: false,
  username: '',
  password: '',
  firstname: '',
  lastname: '',
  userId: '',
  triathleteId: '',
  token: '',
  email: '',
  // eslint-disable-next-line quotes
  roles: ["ROLE_USER"],
  warningMessage: {
    warning: false,
    status: '',
    message: '',
  },
};

// === Reducer
function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case CHANGE_VALUE:
      return {
        ...state,
        [action.key]: action.value,
      };
    case CONNECT_USER:
      return {
        ...state,
        username: '',
        password: '',
        firstname: action.firstname,
        userId: action.userId,
        triathleteId: action.triathleteId,
        token: action.token,
      };
    case LOGIN_ERROR:
      return {
        ...state,
        errorMessage: true,
      };
    case GET_WARNING_MESSAGE:
      return {
        ...state,
        warningMessage: {
          ...state.warningMessage,
          warning: true,
          status: action.status,
          message: action.message,
        },
      };
    case TIMEOUT_WARNING_MESSAGE:
      return {
        ...state,
        warningMessage: {
          ...state.warningMessage,
          warning: false,
          status: '',
          message: '',
        },
      };
    case LOGOUT:
      return {
        ...state,
        firstname: '',
        userId: '',
        triathleteId: '',
        token: '',
        email: '',
        password: '',
        checkedPassword: '',
        lastname: '',
      };
    default:
      return state;
  }
}

// === Export
export default reducer;
