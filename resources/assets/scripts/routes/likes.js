/*global add_like*/

export default {
  init(el) {
    this.canAdd = true;

    el.addEventListener('click', () => this.addLike(el));
  },

  addLike(el) {
    el.classList.add('loading');

    const formData = new FormData();
    const id = el.getAttribute('data-id');

    formData.append('action', 'add_like');
    formData.append('security', add_like.ajax_nonce);
    formData.append('id', id);
    formData.append('type', el.getAttribute('data-type'));

    if (this.canAdd) {
      this.canAdd = false;

      fetch(add_like.ajax_url, {
        method: 'POST',
        body: formData,
      })
        .then(response => response.json())
        .then(({ data }) => {
          const likesCounter = document.querySelectorAll(
            `[data-id="${id}"] .js-likes`
          );

          [].slice.call(likesCounter).forEach(counter => {
            counter.textContent = data;
          });

          this.resetAction(el);
        })
        .catch(e => {
          console.log(e);
          this.resetAction(el);
        });
    }
  },

  resetAction(el) {
    this.canAdd = true;
    el.classList.remove('loading');
  },
};
