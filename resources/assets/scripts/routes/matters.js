/*global liked_articles*/

export default {
  init(el) {
    this.el = el;
    this.currPage = 1;
    this.canLoad = true;
    this.moreButton = el.querySelector('.js-more');
    this.articlesArea = el.querySelector('.js-list');

    if (this.moreButton) {
      this.moreButton.addEventListener('click', e => {
        this.loadingIndicator = e.target;
        this.loadArticles();
      });
    }
  },

  loadArticles() {
    if (this.canLoad) {
      this.canLoad = false;
      this.moreButton.classList.add('loading');

      const formData = new FormData();
      const cat = this.el.getAttribute('data-cat');

      formData.append('action', 'liked_articles');
      formData.append('security', liked_articles.ajax_nonce);
      formData.append('page', this.currPage + 1);

      if (cat) {
        formData.append('category', cat);
      }

      fetch(liked_articles.ajax_url, {
        method: 'POST',
        body: formData,
      })
        .then(response => response.json())
        .then(({ data }) => {
          this.canLoad = true;
          this.currPage = this.currPage + 1;
          this.updateResults(data);
        })
        .catch(e => {
          this.canLoad = true;
          console.log(e);
        });
    }
  },

  updateResults(data) {
    const { articles, total_pages } = data;

    this.moreButton.classList.remove('loading');

    if (articles) {
      this.articlesArea.insertAdjacentHTML('beforeend', articles.join(''));
    }

    if (total_pages <= this.currPage) {
      this.moreButton.remove();
    }
  },
};
