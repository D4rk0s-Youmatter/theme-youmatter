export default {
  init(el) {
    this.setupExpandableContent(
      el.querySelector('.js-expandable'),
      el.querySelector('.js-expand')
    );
  },

  toggleItem(button, content) {
    button.classList.toggle('open');
    content.classList.toggle('open');
  },

  setupExpandableContent(content, button) {
    button.addEventListener('click', e => {
      e.preventDefault();
      this.toggleItem(button, content);
    });
  },
};
