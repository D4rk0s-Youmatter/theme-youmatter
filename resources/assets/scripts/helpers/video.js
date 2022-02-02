import YouTubePlayer from 'youtube-player';

class Video {
  constructor(wrapper, button) {
    this.wrapper = wrapper;
    this.videoEl = this.wrapper.querySelector('[data-video]');
    this.player = null;

    this.setup();
    button.addEventListener('click', () => this.play());
  }

  hide() {
    this.wrapper.classList.remove('playing');
  }

  play() {
    this.show();
    this.player.seekTo(0);
    this.player.playVideo();
  }

  setup() {
    this.player = YouTubePlayer(this.videoEl, {
      videoId: this.videoEl.getAttribute('data-video'),
      playerVars: {
        color: 'white',
        rel: 0,
        modestbranding: 1,
        showsearch: 0,
        iv_load_policy: 3,
      },
    });

    this.player.on('stateChange', e => {
      if (e.data == 0 || e.data == 2) {
        this.hide();
      }

      if (e.data == 1) {
        this.show();
      }
    });
  }

  show() {
    this.wrapper.classList.add('playing');
  }
}

export default Video;
