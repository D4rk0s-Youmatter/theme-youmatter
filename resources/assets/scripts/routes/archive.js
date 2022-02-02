import Select from '../helpers/select';

/*global category_articles*/

export default {
  init(el) {
    this.loadingIndicator = null;
    this.currPage = 1;
    this.canLoad = true;
    this.lang = document.body.getAttribute('data-lang');
    this.form = el.querySelector('.js-form');
    this.label = el.querySelector('.js-label');
    this.moreButton = el.querySelector('.js-more');
    this.articlesArea = el.querySelector('.js-list');

    if (this.moreButton) {
      this.moreButton.addEventListener('click', e => {
        this.loadingIndicator = e.target;
        this.loadArticles(true);
      });
    }

    if (this.form) {
      const selects = [].slice.call(this.form.querySelectorAll('select'));

      if (selects.length) {
        selects.forEach(el => this.setupFilter(el));
      }

      this.form.addEventListener('submit', e => {
        e.preventDefault();

        this.loadingIndicator = e.target.querySelector('[type=submit]');
        this.loadArticles(false, e.target);
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

      formData.append('action', 'category_articles');
      formData.append('security', category_articles.ajax_nonce);
      formData.append('page', this.currPage);
      formData.append('lang', this.lang);

      fetch(category_articles.ajax_url, {
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

  setupFilter(el) {
    new Select(el, {
      placeholder: true,
      noResultsText: el.getAttribute('data-empty'),
      noChoicesText: el.getAttribute('data-empty'),
    });
  },

  updateResults(response, increase) {
    const { articles, articles_label, total_pages } = response.data;

    this.lastPage = total_pages;
    this.label.innerHTML = articles_label;
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
