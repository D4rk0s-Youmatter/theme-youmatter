<footer class="main_footer">
    <div class="wrapper main_footer-wrap">
      <div class="main_footer__first_row row">
        <div class="main_footer__first_row-first-col main_footer__first_row-item">
          <a href="{{ App::homeUrl() }}" class="main_footer__first_row-first-col-logo">
          {!! App::get_attachment_image(App::options()['logo_id'], 'medium') !!}
          </a>
          <p class="main_footer__first_row-first-col-txt">Comprendre le monde qui nous entoure et agir pour l’avenir.</p>
        </div>
        @if (has_nav_menu('footer_menu_1'))
        <div class="main_footer__first_row-item">
          <h3>{{ pll__('Citizen', 'youmatter') }}</h3>
          {!! wp_nav_menu( array( 'theme_location' => 'footer_menu_1', 'container' => false, 'menu_class' => 'menu menu--footer' ) ) !!}
        </div>
        @endif
        @if (has_nav_menu('footer_menu_2'))
        <div class="main_footer__first_row-item">
          <h3>{{ pll__('Pro', 'youmatter') }}</h3>
          {!! wp_nav_menu( array( 'theme_location' => 'footer_menu_2', 'container' => false, 'menu_class' => 'menu menu--footer' ) ) !!}
        </div>
        @endif
        @if (has_nav_menu('footer_menu_3'))
        <div class="main_footer__first_row-item">
          <h3>{{ pll__('Corporate information', 'youmatter') }}</h3>
          {!! wp_nav_menu( array( 'theme_location' => 'footer_menu_3', 'container' => false, 'menu_class' => 'menu menu--footer' ) ) !!}
        </div>
        @endif
        @if (has_nav_menu('footer_menu_4'))
        <div class="main_footer__first_row-item">
            <h3>{{ pll__('Get in touch', 'youmatter') }}</h3>
            {!! wp_nav_menu( array( 'theme_location' => 'footer_menu_4', 'container' => false, 'menu_class' => 'menu menu--footer' ) ) !!}
        </div>
        @endif
      </div>  
    </div>
  </footer>
  