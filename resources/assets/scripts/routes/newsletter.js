export default {
  init(el) {
    this.el = el;

    Array.prototype.slice.call(el.querySelectorAll('input')).forEach(field => {
      field.addEventListener('invalid', e => this.setMessage(e));
      field.addEventListener('input', e => this.setMessage(e));
    });

    Array.prototype.slice
      .call(el.querySelectorAll('input[type=checkbox]'))
      .forEach(field => {
        field.addEventListener('change', e => this.updateGroup(e));
      });

    el.addEventListener('submit', e => this.submitForm(e));
  },

  setMessage(e) {
    const field = e.target;
    const invalidText =
      field.getAttribute('data-invalid') ||
      this.el.getAttribute('data-invalid');

    field.setCustomValidity('');

    if (!field.validity.valid) {
      field.setCustomValidity(invalidText);
    }
  },

  submitForm(e) {
    e.preventDefault();

    const button = e.target.querySelector('[type=submit]');
    const values = new FormData(e.target);

    button.classList.add('loading');

    console.log(values);

    // TODO ACTUAL SUBMIT
  },

  updateGroup(e) {
    const checked = e.target.checked;
    const group = e.target.name;

    Array.prototype.slice
      .call(this.el.querySelectorAll('input[name=' + group + ']'))
      .forEach(checkbox =>
        checked
          ? checkbox.removeAttribute('required')
          : checkbox.setAttribute('required', true)
      );
  },
};
