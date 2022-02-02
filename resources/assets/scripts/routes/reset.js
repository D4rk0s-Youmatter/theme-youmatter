export default {
  init(el) {
    this.el = el;
    this.form = el.querySelector('form');

    if (this.form) {
      this.form.addEventListener('submit', e => {
        e.preventDefault();
        this.resetPass();
      });
    }
  },

  resetPass() {
    const formData = new FormData();
    const msgCtn = this.el.querySelector('.message');
    const email = this.form.querySelector('input[type=email]').value;

    formData.append('action', 'reset_pass');
    formData.append('security', window.reset_pass.ajax_nonce);
    formData.append('email', email);

    fetch(window.reset_pass.ajax_url, {
      method: 'POST',
      body: formData,
    })
      .then(response => response.json())
      .then(response => {
        const msg = response.data;
        this.form.classList.add('hidden');
        msgCtn.classList.remove('hidden');
        msgCtn.innerHTML = msg;
      })
      .catch(e => {
        console.log(e);
      });
  },
};
