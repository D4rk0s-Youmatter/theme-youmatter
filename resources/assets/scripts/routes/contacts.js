import Select from '../helpers/select';

export default {
  init(el) {
    const selects = Array.prototype.slice.call(el.querySelectorAll('select'));

    selects.forEach(item => this.setupSelect(item));
  },

  setupSelect(el) {
    const urlParams = new URLSearchParams(window.location.search);
    const initialOption = parseInt(urlParams.get('opt'), 10);
    let initialChoice = null;

    if (initialOption > 0 && el.getAttribute('name') === 'subject') {
      const option = el.options[initialOption - 1];
      initialChoice = option && option.value;
    }

    const select = new Select(el, {
      removeItems: false,
      removeItemButton: false,
      noResultsText: el.getAttribute('data-empty'),
      noChoicesText: el.getAttribute('data-empty'),
    });

    select.setChoice(initialChoice);
  },
};
