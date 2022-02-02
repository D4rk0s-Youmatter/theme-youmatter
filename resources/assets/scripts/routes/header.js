export default {
  init(el) {
    this.el = el;
    this.openUserMenu = false;

    const userToggle = el.querySelector('.js-user-toggle'),
          searchFormToggle = el.querySelector('.form-banner svg');

    const donateButton = el.querySelector('.js-donate');

    if (donateButton) {
      donateButton.addEventListener('click', e => {
        e.preventDefault();
        const menuOverlay = el.querySelector('.menu--donate');
        menuOverlay.classList.toggle('active');
      });
    }

    el.querySelector('.js-burger').addEventListener('click', () =>
      this.toggleMenu()
    );

    window.addEventListener('scroll', () => this.onScroll());

    this.mainCats = [].slice.call(
      this.el.querySelectorAll('.menu-item-has-children > a')
    );

    this.mainCats.forEach(btn => {
      btn.addEventListener('mouseover', e => this.activateCat(e));
      btn.addEventListener('focus', e => this.activateCat(e));
      btn.addEventListener('click', e => this.activateCat(e));
    });

    el.addEventListener('mouseleave', e => {
      const inUser = e.target.closest('.js-user-toggle');

      this.hideCats();

      if (!inUser && userToggle) {
        userToggle.parentNode
          .querySelector('.js-user-submenu')
          .classList.remove('active');
        userToggle.classList.remove('active');
        this.openUserMenu = false;
      }
    });

    if (userToggle) {
      userToggle.addEventListener('click', e => {
        e.preventDefault();

        userToggle.parentNode
          .querySelector('.js-user-submenu')
          .classList.toggle('active');
        userToggle.classList.toggle('active');
        this.openUserMenu = !this.openUserMenu;
      });
    }

    if(searchFormToggle) {
        searchFormToggle.addEventListener('click', e => {
            e.preventDefault();
            searchFormToggle.parentNode.classList.toggle('active');
          })       
    }

    const languageToggle = el.querySelector('.js-language-toggle');

    if (languageToggle) {
      languageToggle.addEventListener('click', e => {
        e.preventDefault();
        e.currentTarget.parentNode
          .querySelector('.js-language-menu')
          .classList.toggle('active');
        languageToggle.classList.toggle('active');
      });
    }


    // Header messages animations by Jerem
    let messagesDomItems = document.querySelectorAll('.messages .message');

    if(messagesDomItems.length && messagesDomItems.length != 1) {
        let messages = Array.prototype.slice.call( messagesDomItems );
        let messages_count = messages.length;
        let active_message_index = 0;

        
        setInterval(function(){
            let active_message = document.querySelector('.messages .message.active');

            if( messages.indexOf(active_message) == messages_count-1 )
                active_message_index  = 0;
            else
                active_message_index++;
                
            active_message.classList.remove('active');
            document.querySelectorAll('.messages .message')[active_message_index].classList.add('active');
        }, 4000);
    }
    
    /*
    var lis = Array.prototype.slice.call( document.querySelectorAll('.messages .message'));
    var lis_count = lis.length;
    var active_li_index = 0;
    

    setInterval(function(){
       var active_li = document.querySelector('.messages .message.active');
       
       if( lis.indexOf(active_li) == lis_count-1 )
         active_li_index  = 0;
       else
         active_li_index++;
         
       active_li.classList.remove('active');
       document.querySelectorAll('.messages .message')[active_li_index].classList.add('active');
    }, 1000);

*/



  },

  activateCat(e) {
    const current = e.currentTarget.parentNode;
    const ww = window.innerWidth;

    if (
      (e.type === 'click' && !current.classList.contains('special')) ||
      (ww <= 1024 && e.type !== 'click')
    ) {
      return;
    }

    e.preventDefault();
    e.stopImmediatePropagation();

    if (current.classList.contains('active')) {
      current.classList.remove('active');
      return;
    } else {
      this.hideCats();
      current.classList.add('active');

      if (!current.classList.contains('loaded')) {
        const articles = [].slice.call(
          current.querySelectorAll('.menu-articles__card')
        );
        articles.forEach(article => {
          const figure = article.querySelector('.menu-articles__image');
          figure.style = 'background-image: url(' + figure.dataset.image + ')';
        });

        current.classList.add('loaded');
      }
    }
  },

  hideCats() {
    this.mainCats.forEach(cat => {
      cat.parentNode.classList.remove('active');
    });
  },

  onScroll() {
    if (
      window.pageYOffset >
      this.el.querySelector('.js-scroll-offset').clientHeight
    ) {
      this.el.classList.add('fixed');
    } else {
      this.el.classList.remove('fixed');
    }
  },

  toggleMenu() {
    this.el.classList.toggle('open');
  },
};
