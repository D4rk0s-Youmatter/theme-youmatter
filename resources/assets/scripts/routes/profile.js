export default {
  init(el) {
    this.form = el.querySelector('form');
    this.messageCtn = el.querySelector('.update-profile-message');
    this.id = el.dataset.id;

    this.form.addEventListener('submit', e => {
      e.preventDefault();
      this.updateProfile();
    });
  },

  updateProfile() {
    const formData = new FormData(this.form);

    formData.append('action', 'update_profile');
    formData.append('security', window.update_profile.ajax_nonce);
    formData.append('user_id', this.id);

    fetch(window.update_profile.ajax_url, {
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
