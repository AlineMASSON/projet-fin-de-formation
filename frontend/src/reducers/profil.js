import { CHANGE_VALUE } from '../actions/index';
import { GET_INFOS_PROFIL, DELETE_INFOS_PROFIL } from '../actions/profil';

const initialState = {
  infosProfil: [],
};

function reducer(state = initialState, action = {}) {
  switch (action.type) {
    case GET_INFOS_PROFIL:
      return {
        ...state,
        infosProfil: {
          idTri: action.idTri,
          palmares: action.palmares,
          weight: action.weight,
          size: action.size,
          idUser: action.idUser,
          email: action.email,
          password: action.password,
          profile: action.profile,
          lastname: action.lastname,
          firstname: action.firstname,
          description: action.description,
          picture: action.picture,
          gender: action.gender,
          city: action.city,
          date_birth: action.date_birth,
        },
      };
    case CHANGE_VALUE:
      return {
        ...state,
        infosProfil: {
          ...state.infosProfil,
          [action.key]: action.value,
        },
      };
    case DELETE_INFOS_PROFIL:
      return {
        ...state,
        infosProfil: state.infosProfil,
      };
    default:
      return state;
  }
}

export default reducer;
