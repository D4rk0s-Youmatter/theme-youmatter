export default {
  activeClassName: 'lightbox--active',

  init(el) {
    this.el = el;
    this.sections = [].slice.call(this.el.querySelectorAll('section'));

    [].slice
      .call(document.querySelectorAll('[data-lightbox-open]'))
      .forEach(btn => {
        btn.addEventListener('click', e =>
          this.openLightbox(e, btn.getAttribute('data-lightbox-open'))
        );
      });

    [].slice.call(document.querySelectorAll('.js-close')).forEach(btn => {
      btn.addEventListener('click', e => this.closeLightbox(e));
    });

    this.addPlaceholders();
  },

  closeLightbox(e) {
    e.preventDefault();

    [].slice
      .call(document.querySelectorAll('[data-lightbox]'))
      .forEach(lightbox => {
        lightbox.classList.remove(this.activeClassName);
      });
  },

  openLightbox(e, lightbox) {
    e.preventDefault();

    this.closeLightbox(e);

    if (lightbox === 'orgLogo') {
      document
        .querySelector(`[data-lightbox=${lightbox}]`)
        .classList.add(this.activeClassName);
      const imgUrl = e.currentTarget.querySelector('img').getAttribute('src');
      const popinImage = document.createElement('img');
      const LightboxContent = document.querySelector(
        `[data-lightbox=${lightbox}] .lightbox__content`
      );
      popinImage.setAttribute('src', imgUrl);
      LightboxContent.innerHtml = '';
      LightboxContent.appendChild(popinImage);
    } else {
      this.el
        .querySelector(`[data-lightbox=${lightbox}]`)
        .classList.add(this.activeClassName);
    }
  },

  addPlaceholders() {
    const userName = this.el.querySelector('input[name=log]');
    const password = this.el.querySelector('input[name=pwd]');
    if (userName) {
      userName.setAttribute(
        'placeholder',
        userName.parentNode.querySelector('label').innerHTML
      );
    }
    if (password) {
      password.setAttribute(
        'placeholder',
        password.parentNode.querySelector('label').innerHTML
      );
    }
  },
};
