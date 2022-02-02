<footer class="main_footer">
  <div class="wrapper">
    <div class="main_footer__first_row row">
      @if (has_nav_menu('footer_menu_1'))
      <div>
        <h3>{{ pll__('Citizen', 'youmatter') }}</h3>
        {!! wp_nav_menu( array( 'theme_location' => 'footer_menu_1', 'container' => false, 'menu_class' => 'menu menu--footer' ) ) !!}
      </div>
      @endif
      @if (has_nav_menu('footer_menu_2'))
      <div>
        <h3>{{ pll__('Pro', 'youmatter') }}</h3>
        {!! wp_nav_menu( array( 'theme_location' => 'footer_menu_2', 'container' => false, 'menu_class' => 'menu menu--footer' ) ) !!}
      </div>
      @endif
      @if (has_nav_menu('footer_menu_3'))
      <div>
        <h3>{{ pll__('Corporate information', 'youmatter') }}</h3>
        {!! wp_nav_menu( array( 'theme_location' => 'footer_menu_3', 'container' => false, 'menu_class' => 'menu menu--footer' ) ) !!}
      </div>
      @endif
      <div>
        <h3>{{ pll__('Get in touch', 'youmatter') }}</h3>
        <nav class="menu--footer--social">
          <ul class="menu menu--top-3">
            <?php if ( get_field('facebook', 'option')): ?>
              <li>
                <a href="<?php the_field('facebook', 'option'); ?>" target="_blank">
                  @include('partials.svg.facebook')
                </a>
              </li>
            <?php endif; ?>
            <?php if ( get_field('instagram', 'option')): ?>
              <li>
                <a href="<?php the_field('instagram', 'option'); ?>" target="_blank">
                  @include('partials.svg.instagram')
                </a>
              </li>
            <?php endif; ?>
            <?php if ( get_field('twitter', 'option')): ?>
              <li>
                <a href="<?php the_field('twitter', 'option'); ?>" target="_blank">
                  @include('partials.svg.twitter')
                </a>
              </li>
            <?php endif; ?>
            <?php if ( get_field('linkedin', 'option')): ?>
              <li>
                <a href="<?php the_field('linkedin', 'option'); ?>" target="_blank">
                  @include('partials.svg.linkedin')
                </a>
              </li>
            <?php endif; ?>
            <?php if ( get_field('youtube', 'option')): ?>
              <li>
                <a href="<?php the_field('youtube', 'option'); ?>" target="_blank">
                  @include('partials.svg.youtube')
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </nav>
        <div class="main_footer__logos">
          <div class="main_footer__logos__toprow">
            <a href="<?php echo site_url(); ?>" class="main_footer__logo">
             {!! App::get_attachment_image(App::options()['logo_id'], 'medium') !!}
            </a>
          </div>
          <div class="main_footer__logos__bottomrow">
            <a href="<?php echo App::options()['organizations_site_link']; ?>" class="main_footer__logo">
              @include('partials.svg.logoorgs')
            </a>
            <a href="<?php echo App::options()['services_site_link']; ?>" class="main_footer__logo">
              @include('partials.svg.logoserv')
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="main_footer__second_row row">
      @if (has_nav_menu('footer_menu_4'))
        {!! wp_nav_menu( array( 'theme_location' => 'footer_menu_4', 'container' => false, 'menu_class' => 'menu menu--footer menu--footer--small' ) ) !!}
      @endif
    </div>

  </div>
</footer>
