// === Import

import {
  CHANGE_VALUE_TRAINING,
  CLOSE_TRAINING,
  EDIT_TRAINNING,
  FORM_TRAINING,
  GET_ALL_TRAININGS,
  GET_CURRENT_TRAINING,
  SWITCH_DAY,
} from '../actions/trainings';
import { weekGenerator } from '../functions/switchDate';

// === State
const initialState = {
  today: new Date(),
  week: weekGenerator(),
  countSwitchDay: 0,
  loadingAllTrainings: true,
  loadingCurrentTraining: true,
  isPost: false,
  isPatch: false,
  allTrainings: [],
  currentTraining: {},
};

// === Reducer
function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case GET_ALL_TRAININGS:
      return {
        ...state,
        loadingAllTrainings: false,
        allTrainings: action.allTrainings,
      };
    case GET_CURRENT_TRAINING:
      return {
        ...state,
        loadingCurrentTraining: false,
        currentTraining: action.currentTraining,
      };
    case CLOSE_TRAINING:
      return {
        ...state,
        loadingCurrentTraining: true,
        currentTraining: {},
      };
    case EDIT_TRAINNING:
      return {
        ...state,
        loadingCurrentTraining: true,
      };
    case FORM_TRAINING:
      return {
        ...state,
        [action.key]: !action.value,
      };
    case CHANGE_VALUE_TRAINING:
      return {
        ...state,
        currentTraining: {
          ...state.currentTraining,
          [action.key]: action.value,
        },
      };
    case SWITCH_DAY:
      return {
        ...state,
        countSwitchDay: action.count,
        week: weekGenerator(action.count),
      };
    default:
      return state;
  }
}

// === Export
export default reducer;
