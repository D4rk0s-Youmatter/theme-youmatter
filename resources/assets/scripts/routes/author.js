/*global author_articles*/

export default {
  init(el) {
    this.loadingIndicator = null;
    this.currPage = 1;
    this.canLoad = true;
    this.lang = document.body.getAttribute('data-lang');
    this.moreButton = el.querySelector('.js-more');
    this.articlesArea = el.querySelector('.js-list');
    this.author = el.dataset.author;

    if (this.moreButton) {
      this.moreButton.addEventListener('click', e => {
        this.loadingIndicator = e.target;
        this.loadArticles(true);
      });
    }
  },

  loadArticles(increase = false, data) {
    if (increase) {
      this.currPage = this.currPage + 1;
    }

    if (this.canLoad) {
      this.canLoad = false;
      this.loadingIndicator.classList.add('loading');

      const formData = new FormData(data);

      formData.append('action', 'author_articles');
      formData.append('security', author_articles.ajax_nonce);
      formData.append('page', this.currPage);
      formData.append('lang', this.lang);
      formData.append('author', this.author);

      fetch(author_articles.ajax_url, {
        method: 'POST',
        body: formData,
      })
        .then(response => response.json())
        .then(response => {
          this.canLoad = true;
          this.updateResults(response, increase);
        })
        .catch(e => {
          if (increase) {
            this.currPage = this.currPage - 1;
          }
          this.canLoad = true;
          console.log(e);
        });
    }
  },

  updateResults(response, increase) {
    const { articles, total_pages } = response.data;

    this.lastPage = total_pages;
    this.loadingIndicator.classList.remove('loading');

    if (articles) {
      if (!increase) {
        this.articlesArea.innerHTML = '';
      }

      this.articlesArea.insertAdjacentHTML('beforeend', articles.join(''));
    }

    if (total_pages <= this.currPage) {
      this.moreButton.remove();
    }
  },
};
