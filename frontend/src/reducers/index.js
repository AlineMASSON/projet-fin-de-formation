// === Import
import { combineReducers } from 'redux';
import userReducer from './user';
import popupReducer from './popup';
import trainingsReducer from './trainings';
import profilReducer from './profil';

// === State
const rootReducer = combineReducers({
  user: userReducer,
  popup: popupReducer,
  trainings: trainingsReducer,
  profil: profilReducer,
});

// === Export
export default rootReducer;
