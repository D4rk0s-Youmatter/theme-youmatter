/*global search_items*/

export default {
  init(el) {
    this.loadingIndicator = null;


    this.currPage = 1;
    this.canLoad = true;
    this.label = el.querySelector('.js-label');
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
      this.loadingIndicator.classList.add('loading');

      let formData = new FormData();

      formData.append('action', 'search_items');
      formData.append('security', search_items.ajax_nonce);
      formData.append('page', this.currPage + 1);
      formData.append('s', this.articlesArea.getAttribute('data-search'));


      fetch(search_items.ajax_url, {
        method: 'POST',
        body: formData,
      })
        .then(response => response.json())
        .then(response => {
            

          this.canLoad = true;
          this.currPage = this.currPage + 1;
          this.updateResults(response);
        })
        .catch(e => {
          this.canLoad = true;
          console.log(e);
          this.loadingIndicator.classList.remove('loading');
        });
    }
  },

  updateResults(response) {
      console.log(response);
    let { items, items_label, total_pages } = response.data;
    this.lastPage = total_pages;
    this.label.innerHTML = items_label;
    this.loadingIndicator.classList.remove('loading');

    if (items) {
      this.articlesArea.insertAdjacentHTML('beforeend', items.join(''));
    }

    if (total_pages <= this.currPage) {
      this.moreButton.remove();
    }
  },
};
