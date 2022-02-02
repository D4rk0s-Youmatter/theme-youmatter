export default {
  animated: false,

  init(el) {
    var self = this;
    window.addEventListener(
      'scroll',
      function() {
        var vwTop = window.pageYOffset;
        var vwBottom = window.pageYOffset + window.innerHeight;
        var elemTop = el.offsetTop;
        var elemHeight = el.offsetHeight;

        if (vwBottom > elemTop && vwTop - elemHeight < elemTop) {
          if (!self.animated) {
            self.animate(el);
          }
        }
      },
      false
    );
  },

  animate(el) {
    this.animated = true;
    const bar = el.querySelector('i');
    let startValue = 0;
    const percentageValue =
      (el.dataset.current / (el.dataset.end - el.dataset.start)) * 100 * 0.8;

    const t = setInterval(() => {
      if (startValue < percentageValue) {
        startValue += 1;
        bar.style.width = startValue + '%';
      } else {
        clearInterval(t);
      }
    }, 50);
  },
};
