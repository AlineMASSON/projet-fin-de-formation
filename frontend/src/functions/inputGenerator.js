import { useDispatch, useSelector } from 'react-redux';
import dateYYYYMMDD from 'src/functions/dateYYYYMMDD';

import FieldInput from 'src/components/FieldInput/index';
import FieldSelect from 'src/components/FieldSelect';
import FieldTextArea from 'src/components/FieldTextArea';
import Toggle from 'react-toggle';
import { changeValueTraining } from 'src/actions/trainings';
import 'react-toggle/style.css';
import 'src/components/ReactToggle/reactToggleCustom.scss';

export default function inputGenerator(label) {
  const dispatch = useDispatch();
  const training = useSelector((state) => state.trainings.currentTraining);
  const value = training[label.bdd] === undefined ? '' : training[label.bdd];
  const date = training.date !== undefined ? dateYYYYMMDD(training.date) : '';

  const handleChange = (event) => {
    dispatch(changeValueTraining(event.target.name, event.target.checked));
  };

  let render;

  if (label.type === 'select') {
    render = (
      <FieldSelect
        key={label.bdd}
        name={label.bdd}
        content={label.content}
        isRequired={label.isRequired}
        options={label.options}
        value={value}
      />
    );
  }

  if (label.type === 'textarea') {
    render = (
      <FieldTextArea
        key={label.bdd}
        name={label.bdd}
        content={label.content}
        maxLength={label.length}
        isRequired={label.isRequired}
        placeholder={label.placeholder}
        value={value}
      />
    );
  }

  if (label.type === 'toggle') {
    render = (
      <label htmlFor={label.bdd} className="toggle">
        <Toggle
          icons={false}
          key={label.bdd}
          name={label.bdd}
          bdd={label.bdd}
          onChange={handleChange}
          checked={value}
        />
        <p className="toggle__content">{label.content}</p>
      </label>
    );
  }

  if (label.type === 'text' || label.type === 'number') {
    render = (
      <FieldInput
        type={label.type}
        key={label.bdd}
        name={label.bdd}
        content={label.content}
        placeholder={label.placeholder}
        isRequired={label.isRequired}
        value={value}
      />
    );
  }

  if (label.type === 'date') {
    render = (
      <FieldInput
        type={label.type}
        key={label.bdd}
        name={label.bdd}
        content={label.content}
        placeholder={label.placeholder}
        isRequired={label.isRequired}
        value={date}
      />
    );
  }
  return render;
}
