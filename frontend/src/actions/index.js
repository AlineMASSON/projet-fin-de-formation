export const CHANGE_VALUE = 'CHANGE_VALUE';
export const changeValue = (key, value) => ({
  type: CHANGE_VALUE,
  key: key,
  value: value,
});

export const GET_WARNING_MESSAGE = 'GET_WARNING_MESSAGE';
export const getWarningMessage = (status, message) => ({
  type: GET_WARNING_MESSAGE,
  status,
  message,
});

export const TIMEOUT_WARNING_MESSAGE = 'TIMEOUT_WARNING_MESSAGE';
export const timeoutWarningMessage = () => ({
  type: TIMEOUT_WARNING_MESSAGE,
});
