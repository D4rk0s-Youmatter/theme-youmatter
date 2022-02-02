export default {
  init(el) {
    const words = el.getAttribute('data-words').split(',');
    const container = el.querySelector('.js-anim');
    let i = 0;

    if (container && words.length) {
      container.innerHTML = words[i];

      setInterval(() => {
        i = words[i + 1] ? i + 1 : 0;
        container.classList.add('change');

        container.addEventListener('transitionend', () => {
          if (container.classList.contains('change')) {
            container.innerHTML = words[i];
            container.classList.remove('change');
          }
        });
      }, 1500);
    }
  },
};
