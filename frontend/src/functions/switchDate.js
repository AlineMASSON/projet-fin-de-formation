export function switchDate(nbSwitch) {
  const today = new Date();
  const day = today.getDate();
  return new Date(today.setDate(day + nbSwitch));
}

export function weekGenerator(nbSwitch = 0) {
  const weekArray = [];
  for (let day = 0; day < 7; day++) {
    weekArray.push(switchDate(day + nbSwitch));
  }
  return weekArray;
}
