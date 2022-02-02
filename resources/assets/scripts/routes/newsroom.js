import Select from '../helpers/select';

/*global newsroom_articles*/

export default {
  init(el) {
    this.loadingIndicator = null;
    this.currPage = 1;
    this.canLoad = true;
    this.moreButton = el.querySelector('.js-more');
    this.articlesArea = el.querySelector('.js-list');
    this.taxonomy = 0;
    this.form = el.querySelector('form');

    const categorySelect = el.querySelector('.js-choice-category');

    new Select(categorySelect, {
      noResultsText: categorySelect.getAttribute('data-empty'),
      noChoicesText: categorySelect.getAttribute('data-empty'),
    });

    if (this.moreButton) {
      this.loadingIndicator = this.moreButton;
      this.moreButton.addEventListener('click', () => {
        this.loadArticles(true);
      });
    }

    categorySelect.addEventListener('change', e => {
      e.preventDefault();

      this.taxonomy = e.currentTarget.value;
      this.currPage = 1;
      this.loadArticles(false);
    });
  },

  loadArticles(increase = false, data) {
    if (increase) {
      this.currPage = this.currPage + 1;
    }

    if (this.canLoad) {
      this.canLoad = false;
      this.loadingIndicator.classList.add('loading');

      const formData = new FormData(data);

      formData.append('action', 'newsroom_articles');
      formData.append('security', newsroom_articles.ajax_nonce);
      formData.append('page', this.currPage);
      formData.append('taxonomy', this.taxonomy);

      fetch(newsroom_articles.ajax_url, {
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
