export default {
  init(el) {
    this.el = el;
    this.links = el.querySelectorAll('a');

    const headerHeight = document.querySelector('.header').clientHeight;

    this.links.forEach((link) => {
      link.addEventListener('click', (e) => {
        e.preventDefault();
        const targetID = e.currentTarget.hash.substr(1);
        const target = document.getElementById(targetID);

        requestAnimationFrame((timestamp) => {
          const stamp = timestamp || new Date().getTime();
          const duration = 1200;
          const start = stamp;

          const startScrollOffset = window.pageYOffset;
          const scrollEndElemTop =
            target.getBoundingClientRect().top - headerHeight;

          this.scrollToElem(
            start,
            stamp,
            duration,
            scrollEndElemTop,
            startScrollOffset
          );
        });
      });
    });
  },

  easeInCubic(t) {
    return t * t * t;
  },

  scrollToElem(
    startTime,
    currentTime,
    duration,
    scrollEndElemTop,
    startScrollOffset
  ) {
    const runtime = currentTime - startTime;
    let progress = runtime / duration;

    progress = Math.min(progress, 1);

    const ease = this.easeInCubic(progress);

    window.scroll(0, startScrollOffset + scrollEndElemTop * ease);
    if (runtime < duration) {
      requestAnimationFrame((timestamp) => {
        const currentTime = timestamp || new Date().getTime();
        this.scrollToElem(
          startTime,
          currentTime,
          duration,
          scrollEndElemTop,
          startScrollOffset
        );
      });
    }
  },
};
