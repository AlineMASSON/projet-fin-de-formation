export const TOGGLE_POPUP = 'TOGGLE_POPUP';
export const togglePopup = (key, value) => ({
  type: TOGGLE_POPUP,
  key: key,
  value: value,
});

export const DELETE_PROFIL = 'DELETE_PROFIL';
export const deleteProfil = () => ({
  type: DELETE_PROFIL,
});
