export const LOGIN = 'LOGIN';
export const login = () => ({
  type: LOGIN,
});

export const CONNECT_USER = 'CONNECT_USER';
export const connectUser = (firstname, userId, triathleteId, token) => ({
  type: CONNECT_USER,
  firstname,
  userId,
  triathleteId,
  token,
});

export const SIGNIN = 'SIGNIN';
export const signin = () => ({
  type: SIGNIN,
});


export const LOGIN_ERROR = 'LOGIN_ERROR';
export const loginError = () => ({
  type: LOGIN_ERROR,
});

export const LOGOUT = 'LOGOUT';
export const logout = () => ({
  type: LOGOUT,
});
