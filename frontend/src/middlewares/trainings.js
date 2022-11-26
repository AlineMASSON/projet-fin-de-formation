import axios from 'axios';
import url from 'src/url/';
import { getWarningMessage, timeoutWarningMessage } from '../actions';

import {
  getAllTrainings,
  GET_DATAS,
  GET_CURRENT_TRAINING_ID,
  getCurrentTraining,
  ADD_NEW_TRAINING,
  getDatas,
  SAVE_EDIT_TRAINING,
  SAVE_REVIEW,
  DELETE_TRAINING,
  closeTraining,
} from '../actions/trainings';

const trainings = (store) => (next) => (action) => {
  switch (action.type) {
    case GET_DATAS: {
      const { user: { triathleteId, token } } = store.getState();

      axios.get(`${url}triathletes/${triathleteId}/trainings`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
        .then((response) => {
          store.dispatch(getAllTrainings(response.data));
        })
        .catch((error) => {
          console.log(error.response.data);
        });

      next(action);
      break;
    }
    case GET_CURRENT_TRAINING_ID: {
      const { user: { token } } = store.getState();
      axios.get(`${url}trainings/${action.currentTrainingId}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
        .then((response) => {
          store.dispatch(getCurrentTraining(response.data));
        })
        .catch((error) => {
          console.log(error.response.data);
        });

      next(action);
      break;
    }
    case ADD_NEW_TRAINING: {
      const { user: { token } } = store.getState();
      const { trainings: { currentTraining } } = store.getState();
      const { user: { triathleteId } } = store.getState();
      const headers = {
        headers: { Authorization: `Bearer ${token}` },
      };

      const datas = {
        title: currentTraining.title,
        // duration en string, parseInt change le format en entier, le 10 est le format décimal
        duration: parseInt(currentTraining.duration, 10),
        description: currentTraining.description,
        date: currentTraining.date,
        sport: currentTraining.sport,
        isPpg: currentTraining.isPpg === undefined ? false : currentTraining.isPpg,
        feeling: '',
        type: currentTraining.type,
        isValidated: false,
        tag: currentTraining.tag,
        triathlete: parseInt(triathleteId, 10),
      };

      axios.post(
        `${url}trainings`,
        datas,
        headers,
      )
        .then((response) => {
          store.dispatch(getDatas());
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
    case SAVE_EDIT_TRAINING: {
      const { user: { token } } = store.getState();
      const { trainings: { currentTraining } } = store.getState();

      const headers = {
        headers: { Authorization: `Bearer ${token}` },
      };

      const datas = {
        title: currentTraining.title,
        // duration en string, parseInt change le format en entier, le 10 est le format décimal
        duration: parseInt(currentTraining.duration, 10),
        description: currentTraining.description,
        date: currentTraining.date,
        sport: currentTraining.sport,
        isPpg: currentTraining.isPpg === undefined ? false : currentTraining.isPpg,
        feeling: currentTraining.feeling === undefined ? '' : currentTraining.feeling,
        type: currentTraining.type,
        isValidated: currentTraining.isValidated,
        tag: currentTraining.tag,
      };

      axios.patch(
        `${url}trainings/${currentTraining.id}`,
        datas,
        headers,
      )
        .then((response) => {
          store.dispatch(getDatas());
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

    case SAVE_REVIEW: {
      const { user: { token } } = store.getState();
      const { trainings: { currentTraining } } = store.getState();
      const headers = {
        headers: { Authorization: `Bearer ${token}` },
      };

      const datas = {
        content: currentTraining.addReview,
      };

      axios.post(
        `${url}trainings/${currentTraining.id}/review`,
        datas,
        headers,
      )
        .then((response) => {
          console.log(response.data);
          store.dispatch(getDatas());
        })
        .catch((error) => {
          console.log(error.response.data);
        });

      next(action);
      break;
    }
    case DELETE_TRAINING: {
      const { user: { token } } = store.getState();
      const { trainings: { currentTraining } } = store.getState();
      const headers = {
        headers: { Authorization: `Bearer ${token}` },
      };

      axios.delete(
        `${url}trainings/${currentTraining.id}`,
        headers,
      )
        .then((response) => {
          store.dispatch(getDatas());
          store.dispatch(getWarningMessage(response.statusText, response.data.message));
          store.dispatch(closeTraining());
          setTimeout(() => store.dispatch(timeoutWarningMessage()), 5000);
        })
        .catch((error) => {
          store.dispatch(getWarningMessage(error.response.statusText, error.response.data.message));
          store.dispatch(closeTraining());
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

export default trainings;
