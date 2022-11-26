import axios from 'axios';
import url from 'src/url/';
import { getWarningMessage, timeoutWarningMessage } from '../actions';

import {
  getInfosProfil,
  DELETE_INFOS_PROFIL,
  EDIT_INFOS_PROFIL,
} from '../actions/profil';
import { GET_DATAS } from '../actions/trainings';

const profil = (store) => (next) => (action) => {
  switch (action.type) {
    case GET_DATAS: {
      const { user: { triathleteId, token } } = store.getState();

      const config = {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      };

      axios.get(`${url}triathletes/${triathleteId}`, config)

        .then((response) => {
          store.dispatch(getInfosProfil(
            response.data.id,
            response.data.palmares,
            response.data.weight,
            response.data.size,
            response.data.user.id,
            response.data.user.email,
            response.data.user.password,
            response.data.user.profile,
            response.data.user.lastname,
            response.data.user.firstname,
            response.data.user.description,
            response.data.user.picture,
            response.data.user.gender,
            response.data.user.city,
            response.data.user.date_birth,
          ));
        })
        .catch((error) => {
          console.log(error);
        });

      next(action);
      break;
    }

    case EDIT_INFOS_PROFIL: {
      const { user: { token } } = store.getState();
      const { profil: { infosProfil } } = store.getState();

      const config = {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      };

      const bodyParameter = {
        id: parseInt(infosProfil.idUser, 10),
        email: infosProfil.email,
        profile: parseInt(infosProfil.profile, 10),
        lastname: infosProfil.lastname,
        firstname: infosProfil.firstname,
        description: infosProfil.description,
        gender: parseInt(infosProfil.gender, 10),
        city: infosProfil.city,
        date_birth: infosProfil.date_birth,
        triathlete: {
          id: parseInt(infosProfil.idTri, 10),
          palmares: infosProfil.palmares,
          weight: parseInt(infosProfil.weight, 10),
          size: parseInt(infosProfil.size, 10),
        },
        collaborations: [],
      };

      axios.patch(`${url}triathletes/${infosProfil.idTri}`, bodyParameter, config)
        .then((response) => {
          store.dispatch(getWarningMessage(response.statusText, response.data.message));
          setTimeout(() => store.dispatch(timeoutWarningMessage()), 5000);
        })
        .catch((error) => {
          store.dispatch(getWarningMessage(error.response.statusText, error.response.data.message));
          setTimeout(() => store.dispatch(timeoutWarningMessage()), 5000);
        });

      next(action);
      break;
    }

    case DELETE_INFOS_PROFIL: {
      const { user: { token } } = store.getState();
      const { profil: { infosProfil } } = store.getState();

      const config = {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      };

      axios.delete(`${url}triathletes/${infosProfil.idTri}`, config)
        .then((response) => {
          store.dispatch(getWarningMessage(response.statusText, response.data.message));
          setTimeout(() => store.dispatch(timeoutWarningMessage()), 5000);
          window.location.href = '/';
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

export default profil;
