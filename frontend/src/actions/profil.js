export const GET_INFOS_PROFIL = 'GET_INFOS_PROFIL';
export const getInfosProfil = (
  idTri,
  palmares,
  weight,
  size,
  idUser,
  email,
  password,
  profile,
  lastname,
  firstname,
  description,
  picture,
  gender,
  city,
  // eslint-disable-next-line camelcase
  date_birth,
) => ({
  type: GET_INFOS_PROFIL,
  idTri,
  palmares,
  weight,
  size,
  idUser,
  email,
  password,
  profile,
  lastname,
  firstname,
  description,
  picture,
  gender,
  city,
  // eslint-disable-next-line camelcase
  date_birth,
});

export const GET_PROFIL_FROM_API = 'GET_PROFIL_FROM_API';
export const getProfilFromApi = () => ({
  type: GET_PROFIL_FROM_API,
});

export const EDIT_INFOS_PROFIL = 'EDIT_INFOS_PROFIL';
export const editInfosProfil = () => ({
  type: EDIT_INFOS_PROFIL,
});

export const DELETE_INFOS_PROFIL = 'DELETE_INFOS_PROFIL';
export const deleteInfosProfil = (infosProfil) => ({
  type: DELETE_INFOS_PROFIL,
  infosProfil: infosProfil,
});
