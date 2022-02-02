export default {
  init(el) {
    this.el = el;

    this.letterLinks = [].slice.call(this.el.querySelectorAll('.definition__header__link'));

    this.letterLinks.forEach(btn => {
      btn.addEventListener('click', e => this.scrollTo(e));
    });

    this.scrollTopBtn = this.el.querySelector('.definition__go_top');

    this.scrollTopBtn.addEventListener('click', e => this.scrollTop(e));

    window.addEventListener('scroll', () => this.placeBtn());
  },

  scrollTo(e) {
    e.preventDefault();
    this.removeActiveState();
    const target = document.getElementById(e.currentTarget.getAttribute('rel'));
    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    e.currentTarget.classList.add('definition__header__link--active');
  },

  removeActiveState() {
    this.letterLinks.forEach(btn => {
      btn.classList.remove('definition__header__link--active');
    });
  },

  scrollTop(e) {
    e.preventDefault();

    const target = this.el.querySelector('.definition__header');
    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
  },

  placeBtn() {
    const footer = document.querySelector('.main_footer');

    if (
      this.getRectTop(this.scrollTopBtn) + document.body.scrollTop + this.scrollTopBtn.offsetHeight >=
      this.getRectTop(footer) + document.body.scrollTop - 10
    )
      this.scrollTopBtn.classList.add('absolute');
    if (document.body.scrollTop + window.innerHeight < this.getRectTop(footer) + document.body.scrollTop)
      this.scrollTopBtn.classList.remove('absolute');
  },

  getRectTop(el) {
    const rect = el.getBoundingClientRect();
    return rect.top;
  },
};
