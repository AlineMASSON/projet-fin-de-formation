import axios from 'axios';
import url from 'src/url/';
import { togglePopup } from 'src/actions/popup';
import { getWarningMessage, timeoutWarningMessage } from '../actions';
import {
  connectUser,
  LOGIN,
  loginError,
  logout,
  SIGNIN,
} from '../actions/user';

const user = (store) => (next) => (action) => {
  switch (action.type) {
    case LOGIN: {
      const { user: { username, password } } = store.getState();
      const { popup: { isFormLogin } } = store.getState();

      axios.post(`${url}login`, {
        username: username,
        password: password,
      })
        .then((response) => {
          window.localStorage.setItem('token', response.data.token);
          window.localStorage.setItem('triathleteId', response.data.triathleteId);
          window.localStorage.setItem('userId', response.data.userId);
          window.localStorage.setItem('firstname', response.data.firstname);
          window.localStorage.setItem('username', response.data.email);
          store.dispatch(togglePopup('isFormLogin', isFormLogin));
          window.location.href = '/triathlete';
        })
        .catch((error) => {
          console.log(error);
          store.dispatch(loginError());
        });

      next(action);
      break;
    }
    case SIGNIN: {
      const {
        user: {
          firstname,
          lastname,
          email,
          password,
          roles,
        },
      } = store.getState();

      const datas = {
        profile: 1,
        firstname: firstname,
        lastname: lastname,
        email: email,
        password: password,
        roles: roles,
      };

      axios.post(`${url}register`, datas)
        .then((response) => {
          store.dispatch(connectUser(
            response.data.firstname,
            response.data.logged,
            response.data.token,
          ));
          store.dispatch(getWarningMessage(response.statusText, response.data.message));
          store.dispatch(logout());
          setTimeout(() => store.dispatch(timeoutWarningMessage()), 5000);
        })
        .catch((error) => {
          store.dispatch(getWarningMessage(error.response.statusText, error.response.data.message));
          setTimeout(() => store.dispatch(timeoutWarningMessage()), 5000);
        });

      next(action);
      break;
    }
    default:
      next(action);
      break;
  }
};

export default user;
