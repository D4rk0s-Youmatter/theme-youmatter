export default {
  init(el) {
    const limit = el.getAttribute('data-limit');

    if (limit) {
      this.setupExpandableItems(
        [].slice.call(
          el.querySelectorAll(`.card:nth-of-type(n + ${parseInt(limit) + 1})`)
        ),
        el.querySelector('.js-expand')
      );
    } else {
      this.setupExpandableContent(
        el.querySelector('.js-expandable'),
        el.querySelector('.js-expand')
      );
    }
  },

  hideButton(button) {
    button.classList.add('open');
  },

  showButton(button) {
    button.classList.remove('open');
  },

  setupExpandableContent(content, button) {
    content.offsetHeight >= content.scrollHeight
      ? this.hideButton(button)
      : this.showButton(button);

    button.addEventListener('click', e => {
      e.preventDefault();
      this.hideButton(button);
      content.classList.add('open');
    });
  },

  setupExpandableItems(items, button) {
    if (items.length) {
      this.toggleItems(items);
      this.showButton(button);
    } else {
      this.hideButton(button);
    }

    button.addEventListener('click', () => {
      this.hideButton(button);
      this.toggleItems(items);
    });
  },

  toggleItems(items) {
    items.forEach(item => item.classList.toggle('hidden'));
  },
};
