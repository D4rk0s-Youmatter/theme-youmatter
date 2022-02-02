/*global comments_list*/
/*global comments_reply*/

export default {
  init(el) {
    this.el = el;
    this.post = parseInt(el.getAttribute('data-post'));
    this.loadingIndicator = null;
    this.currPage = 1;
    this.canLoad = true;
    this.form = el.querySelector('.js-form');
    this.infoBox = el.querySelector('.js-info');
    this.moreButton = el.querySelector('.js-more');
    this.commentsArea = el.querySelector('.js-list');

    if (this.moreButton) {
      this.moreButton.addEventListener('click', e => {
        this.loadingIndicator = e.target;
        this.loadComments();
      });
    }

    if (this.form) {
      this.form.addEventListener('submit', e => {
        e.preventDefault();

        this.submitForm(e.target);
      });
    }

    this.addReplyEvents();
  },

  addReplyEvents() {
    Array.prototype.slice
      .call(this.el.querySelectorAll('.js-reply'))
      .forEach(button => {
        button.addEventListener('click', () => {
          this.form.querySelector(
            '[name="comment_parent"]'
          ).value = button.getAttribute('data-comment');
        });
      });
  },

  loadComments() {
    if (this.canLoad) {
      this.currPage = this.currPage + 1;
      this.canLoad = false;
      this.loadingIndicator.classList.add('loading');

      const formData = new FormData();

      formData.append('action', 'comments_list');
      formData.append('security', comments_list.ajax_nonce);
      formData.append('page', this.currPage);
      formData.append('post', this.post);

      fetch(comments_list.ajax_url, {
        method: 'POST',
        body: formData,
      })
        .then(response => response.json())
        .then(response => {
          this.canLoad = true;
          this.updateResults(response);
        })
        .catch(e => {
          this.currPage = this.currPage - 1;
          this.canLoad = true;
          console.log(e);
        });
    }
  },

  submitForm(data) {
    if (this.canLoad) {
      this.canLoad = false;
      this.infoBox.innerText = '';

      const formData = new FormData(data);

      formData.append('action', 'comments_reply');
      formData.append('security', comments_reply.ajax_nonce);
      formData.append('page', this.currPage);
      formData.append('post', this.post);

      fetch(comments_reply.ajax_url, {
        method: 'POST',
        body: formData,
      })
        .then(response => response.json())
        .then(({ data }) => {
          this.canLoad = true;
          this.infoBox.innerText = data;
        })
        .catch(({ data }) => {
          this.canLoad = true;
          this.infoBox.innerText = data;
        });
    }
  },

  updateResults(response) {
    const comments = response.data;

    this.loadingIndicator.classList.remove('loading');

    if (comments) {
      this.commentsArea.insertAdjacentHTML('beforeend', comments);

      this.addReplyEvents();
    } else {
      this.moreButton.remove();
    }
  },
};
