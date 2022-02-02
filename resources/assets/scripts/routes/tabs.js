import Select from '../helpers/select';

export default {
  init(el) {
    this.tabsURL = [];
    this.commitsURL = [];
    this.tabBtns = [].slice.call(el.querySelectorAll('.tabs__nav a'));
    this.tabBtns.forEach((tab, index) => {
      this.tabsURL.push(tab.dataset.url);
      tab.addEventListener('click', e => this.selectTab(e));
      index === 0
        ? tab.classList.add('active')
        : tab.classList.remove('active');
    });

    this.tabsContent = [].slice.call(el.querySelectorAll('.tab__content'));

    this.wrap = el.querySelector('.tabs__content__wrap');

    this.sidenavCommitItems = [].slice.call(
      el.querySelectorAll('.sidenav__commits .sidenav__item')
    );
    this.sidenavCommitItems.forEach(btn => {
      this.commitsURL.push(btn.dataset.url);
      btn.addEventListener('click', e => this.commitsNav(e));
    });

    this.commits = [].slice.call(
      this.tabsContent[1].querySelectorAll('article')
    );

    this.sidenavFaqItems = [].slice.call(
      el.querySelectorAll('.sidenav__faqs .sidenav__item')
    );
    this.sidenavFaqItems.forEach(btn => {
      btn.addEventListener('click', e => this.faqsNav(e));
    });

    this.faqs = [].slice.call(this.tabsContent[4].querySelectorAll('article'));

    this.loadingIndicator = null;
    this.currPage = 1;
    this.canLoad = true;
    this.lang = document.body.getAttribute('data-lang');
    this.moreButton = el.querySelector('.js-more');
    this.articlesArea = el.querySelector('.js-list');
    this.authors = el.dataset.authors;

    if (this.moreButton) {
      this.moreButton.addEventListener('click', e => {
        this.loadingIndicator = e.target;
        this.loadArticles(true);
      });
    }

    this.setupFilter(el.querySelector('.js-faq'));

    this.startTab = el.dataset.tab;
    this.startCommit = el.dataset.commit;

    console.log(this.startTab);
    console.log(this.startCommit);

    if (this.startTab) {
      this.tabsURL.filter((tab, index) => {
        if (tab === this.startTab) {
          this.tabBtns[index].click();
        }
      });
      if (this.startCommit) {
        this.commitsURL.filter((commit, index) => {
          if (commit === this.startCommit) {
            this.sidenavCommitItems[index].click();
          }
        });
      }
    }
  },

  setupFilter(el) {
    new Select(el, {
      placeholder: true,
      removeItemButton: true,
    });

    el.addEventListener('change', e => {
      e.preventDefault();

      const value = e.target.value;

      if (value !== null) {
        this.hideFaqs();

        let found = false;
        this.sidenavFaqItems.forEach(item => {
          const cats = item.dataset.cat.split(',');

          if (cats.indexOf(value) >= 0) {
            item.classList.remove('hidden');
            if (!found) {
              item.classList.add('active');
            } else {
              item.classList.remove('active');
            }
            found = true;
          } else {
            item.classList.add('hidden');
          }
        });

        found = false;
        this.faqs.forEach(item => {
          const cats = item.dataset.cat.split(',');
          if (cats.indexOf(value) >= 0 && !found) {
            item.classList.remove('hidden');
            found = true;
          } else {
            item.classList.add('hidden');
          }
        });
      } else {
        this.sidenavFaqItems.forEach(item => {
          item.classList.remove('hidden');
        });
        this.faqs.forEach(item => {
          item.classList.remove('hidden');
        });
      }
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

      formData.append('action', 'organisations_articles');
      formData.append('security', window.organisations_articles.ajax_nonce);
      formData.append('page', this.currPage);
      formData.append('lang', this.lang);
      formData.append('authors', this.authors);

      fetch(window.organisations_articles.ajax_url, {
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

  selectTab(e) {
    e.preventDefault();
    history.pushState(
      {},
      e.currentTarget.innerHTML,
      e.currentTarget.getAttribute('href')
    );
    this.unmarkTabs();
    e.currentTarget.classList.add('active');
    this.hideSections();
    const index = this.tabBtns.indexOf(e.currentTarget);
    this.tabsContent[index].classList.remove('hidden');
    this.formatTab(index);
  },

  unmarkTabs() {
    this.tabBtns.forEach(btn => {
      btn.classList.remove('active');
    });
  },

  hideSections() {
    this.tabsContent.forEach(tab => {
      tab.classList.add('hidden');
    });
  },

  commitsNav(e) {
    e.preventDefault();
    history.pushState(
      {},
      e.currentTarget.innerHTML,
      e.currentTarget.getAttribute('href')
    );
    this.hideCommits();
    this.unmarkCommitsNav();
    const index = this.sidenavCommitItems.indexOf(e.currentTarget);
    this.commits[index].classList.remove('hidden');
    this.sidenavCommitItems[index].classList.add('active');
  },

  hideCommits() {
    this.commits.forEach(commit => {
      commit.classList.add('hidden');
    });
  },

  unmarkCommitsNav() {
    this.sidenavCommitItems.forEach(btn => {
      btn.classList.remove('active');
    });
  },

  faqsNav(e) {
    e.preventDefault();
    this.hideFaqs();
    this.unmarkFaqsNav();
    const index = this.sidenavFaqItems.indexOf(e.currentTarget);
    this.faqs[index].classList.remove('hidden');
    this.sidenavFaqItems[index].classList.add('active');
  },

  unmarkFaqsNav() {
    this.sidenavFaqItems.forEach(btn => {
      btn.classList.remove('active');
    });
  },

  hideFaqs() {
    this.faqs.forEach(faq => {
      faq.classList.add('hidden');
    });
  },

  formatTab(index) {
    switch (index) {
      case 0:
        this.wrap.classList.remove('tabs__content__wrap--full');
        this.wrap.classList.remove('tabs__content__wrap--inverse');
        break;

      case 1:
        this.wrap.classList.add('tabs__content__wrap--inverse');
        this.wrap.classList.remove('tabs__content__wrap--full');
        break;

      case 2:
        this.wrap.classList.add('tabs__content__wrap--full');
        this.wrap.classList.remove('tabs__content__wrap--inverse');
        break;

      case 3:
        this.wrap.classList.add('tabs__content__wrap--full');
        this.wrap.classList.remove('tabs__content__wrap--inverse');
        break;

      case 4:
        this.wrap.classList.remove('tabs__content__wrap--full');
        this.wrap.classList.add('tabs__content__wrap--inverse');
        break;
    }
  },
};
