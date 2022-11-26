export default function dateYYYYMMDD(date) {
  const dateArray = date.split('-');
  const part1 = dateArray[0];
  const part2 = dateArray[1];
  const part3 = dateArray[2];
  if (part3.length === 4) {
    return `${part3}-${part2}-${part1}`;
  }
  return date;
}
