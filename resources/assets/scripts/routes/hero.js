export default {
  init(el) {
    const btn = el.querySelector('.btn');
    const img = el.querySelector('figure');
    const video = el.querySelector('iframe');

    if (btn) {
      btn.addEventListener('click', e => {
        e.preventDefault();
        img.style.display = 'none';
        video.style.opacity = 1;
        btn.style.display = 'none';
      });
    }
  },
};
