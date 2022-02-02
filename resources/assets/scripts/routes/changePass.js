export default {
  init(el) {
    this.el = el;
    this.form = el.querySelector('form');
    this.messageCtn = el.querySelector('.change-password-message');
    this.id = el.dataset.id;

    this.form.addEventListener('submit', e => {
      e.preventDefault();
      this.validatePass();
    });
  },

  validatePass() {
    const password1 = this.el.querySelector('input[name=password_input]');
    const password2 = this.el.querySelector(
      'input[name=confirm_password_input]'
    );

    if (password1.value === password2.value) {
      password2.setCustomValidity('');
      this.changePassword();
    } else {
      password2.setCustomValidity('Passwords must match');
    }
  },

  changePassword() {
    const formData = new FormData(this.form);

    formData.append('action', 'change_pass');
    formData.append('security', window.change_pass.ajax_nonce);
    formData.append('user_id', this.id);

    fetch(window.change_pass.ajax_url, {
      method: 'POST',
      body: formData,
    })
      .then(response => response.json())
      .then(response => {
        if (response.success) {
          this.form.classList.add('hidden');
          this.messageCtn.classList.remove('hidden');
          this.messageCtn.innerHTML = response.data;
        }
      })
      .catch(e => {
        console.log(e);
      });
  },
};
