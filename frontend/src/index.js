// == Import : npm
import { createRoot } from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import { Provider } from 'react-redux';
import store from 'src/store';

// == Import : local
// Composants
import UpTrain from 'src/components/UpTrain';

// == Render
const rootReactElement = (
  <Provider store={store}>
    <BrowserRouter>
      <UpTrain />
    </BrowserRouter>
  </Provider>
);

const root = createRoot(document.getElementById('root'));

root.render(rootReactElement);
