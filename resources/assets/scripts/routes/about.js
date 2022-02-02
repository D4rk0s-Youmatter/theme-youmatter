export default {
  init(el) {
    const loadMore = el.querySelector('.js-loadmore');
    const extraUsers = el.querySelector('.about__team__members--extra');

    loadMore.addEventListener('click', e => {
      e.preventDefault();
      extraUsers.style.display = 'grid';
      loadMore.style.display = 'none';
    });
  },
};
