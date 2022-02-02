export default {
  init(el) {
    this.el = el;
    this.form = el.querySelector('form');

    if (this.form) {
      this.form.addEventListener('submit', e => {
        e.preventDefault();
        this.register();
      });
    }
  },

  register() {
    const formData = new FormData(this.form);
    const msgCtn = this.el.querySelector('.message');

    formData.append('action', 'register_user');
    formData.append('security', window.register_user.ajax_nonce);

    fetch(window.register_user.ajax_url, {
      method: 'POST',
      body: formData,
    })
      .then(response => response.json())
      .then(response => {
        let msg = '';
        if (!response.success) {
          response.data.forEach(item => {
            msg += item.message + '<br>';
          });
        } else {
          msg += response.data + '<br>';
        }
        this.form.classList.add('hidden');
        msgCtn.classList.remove('hidden');
        msgCtn.innerHTML = msg;
      })
      .catch(e => {
        console.log(e);
      });
  },
};
