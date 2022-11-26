export const GET_DATAS = 'GET_DATAS';
export const getDatas = () => ({
  type: GET_DATAS,
});

export const GET_ALL_TRAININGS = 'GET_ALL_TRAININGS';
export const getAllTrainings = (allTrainings) => ({
  type: GET_ALL_TRAININGS,
  allTrainings,
});

export const GET_CURRENT_TRAINING_ID = 'GET_CURRENT_TRAINING_ID';
export const getCurrentTrainingId = (currentTrainingId) => ({
  type: GET_CURRENT_TRAINING_ID,
  currentTrainingId,
});

export const GET_CURRENT_TRAINING = 'GET_CURRENT_TRAINING';
export const getCurrentTraining = (currentTraining) => ({
  type: GET_CURRENT_TRAINING,
  currentTraining,
});

export const CLOSE_TRAINING = 'CLOSE_TRAINING';
export const closeTraining = () => ({
  type: CLOSE_TRAINING,
});

export const FORM_TRAINING = 'FORM_TRAINING';
export const formTraining = (key, value) => ({
  type: FORM_TRAINING,
  key,
  value,
});

export const ADD_NEW_TRAINING = 'ADD_NEW_TRAINING';
export const addNewTraining = () => ({
  type: ADD_NEW_TRAINING,
});

export const CHANGE_VALUE_TRAINING = 'CHANGE_VALUE_TRAINING';
export const changeValueTraining = (key, value) => ({
  type: CHANGE_VALUE_TRAINING,
  key,
  value,
});

export const EDIT_TRAINNING = 'EDIT_TRAINNING';
export const editTraining = () => ({
  type: EDIT_TRAINNING,
});

export const SAVE_EDIT_TRAINING = 'SAVE_EDIT_TRAINING';
export const saveEditTraining = () => ({
  type: SAVE_EDIT_TRAINING,
});

export const SAVE_REVIEW = 'SAVE_REVIEW';
export const SaveReview = () => ({
  type: SAVE_REVIEW,
});

export const DELETE_TRAINING = 'DELETE_TRAINING';
export const deleteTraining = () => ({
  type: DELETE_TRAINING,
});

export const SWITCH_DAY = 'SWITCH_DAY';
export const switchDay = (count) => ({
  type: SWITCH_DAY,
  count,
});
