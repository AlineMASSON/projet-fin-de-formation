// === Import
// Redux
import { createStore, applyMiddleware, compose } from 'redux';
// Reducer
import reducer from 'src/reducers';
import user from '../middlewares/user';
import trainings from '../middlewares/trainings';
import profil from '../middlewares/profil';

// Redux Dev Tools
const composeEnhancers = window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__ || compose;

const enhancers = composeEnhancers(
  applyMiddleware(user, trainings, profil),
);
// === Store
const store = createStore(reducer, enhancers);

// == Export
export default store;
