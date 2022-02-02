import Video from '../helpers/video';

export default {
  init(el) {
    new Video(el, el.querySelector('.js-button'));
  },
};
