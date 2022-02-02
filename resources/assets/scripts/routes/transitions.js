import Select from '../helpers/select';

/*global list_transitions*/

export default {
  init(el) {
    this.loadingIndicator = null;
    this.currPage = 1;
    this.canLoad = true;
    this.form = el.querySelector('.js-form');
    this.moreButton = el.querySelector('.js-more');
    this.itemsArea = el.querySelector('.js-list');

    const selects = [].slice.call(this.form.querySelectorAll('select'));

    if (selects.length) {
      selects.forEach(el => this.setupFilter(el));
    }

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

      formData.append('action', 'list_transitions');
      formData.append('security', list_transitions.ajax_nonce);
      formData.append('page', this.currPage);

      fetch(list_transitions.ajax_url, {
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

    el.addEventListener('change', e => {
      e.preventDefault();

      this.loadingIndicator = e.target.closest('.form__control');
      this.loadArticles(false, this.form);
    });
  },

  updateResults(response, increase) {
    const { items, total_pages } = response.data;

    this.lastPage = total_pages;
    this.loadingIndicator.classList.remove('loading');

    if (items) {
      if (!increase) {
        this.itemsArea.innerHTML = '';
      }

      this.itemsArea.insertAdjacentHTML('beforeend', items.join(''));
    }

    if (total_pages <= this.currPage) {
      this.moreButton.classList.add('hidden');
    } else {
      this.moreButton.classList.remove('hidden');
    }
  },
};
