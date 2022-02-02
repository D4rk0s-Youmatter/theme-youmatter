<?php
  $siteLanguage = get_bloginfo('language');
  $languageShort= explode('-',$siteLanguage);

  $siteURL = get_site_url(2);

?>

<header class="header bg-white" data-control="header">
  <div class="header__wrap">
    <div class="header__controls js-scroll-offset">
      <div class="header__logo__wrap">
        <a href="{{ App::homeUrl() }}" class="header__logo">
          {!! App::get_attachment_image(App::options()['logo_id'], 'medium') !!}
        </a>
        @if (has_nav_menu('donate_menu'))
          <div class="header__donate-menu">
            <a href="#" class="btn js-donate">{{pll__('Nous soutenir', 'youmatter') }}</a>
            {!! wp_nav_menu( array( 'theme_location' => 'donate_menu', 'container' => false, 'menu_class' => 'menu menu--donate' ) ) !!}
          </div>
        @endif

      </div>
      <button
        class="header__burger js-burger"
        data-label-open="{!! pll__('Close', 'youmatter') !!}"
        data-label-closed="{!! pll__('Menu', 'youmatter') !!}"
      >
        <span class="screen-reader-text">{!! pll__('Menu', 'youmatter') !!}</span>
      </button>
    </div>
    <div class="header__aside">
      <nav class="top-menu menu--top">
        @if (has_nav_menu('top_menu'))
          {!! wp_nav_menu( array( 'theme_location' => 'top_menu', 'container' => false, 'menu_class' => 'menu menu--top' ) ) !!}
        @endif
      </nav>
      <nav class="languages">
        <button class="languages__toggle js-language-toggle"><?= $languageShort[0] ?></button>
        @if (App::getLanguageCount() <= 1 )
          <ul class="languages__submenu js-language-menu">
            <li><a href="<?= get_site_url(3); ?>">FR</a></li>
            <li><a href="<?= get_site_url(2); ?>">EN</a></li>
          </ul>
        @else
          <ul class="languages__submenu js-language-menu">
            @php pll_the_languages(array( 'display_names_as' => 'slug' )) @endphp
          </ul>
        @endif


      </nav>
      <nav class="top-menu--2" data-control="lightbox">
        <ul class="menu menu--top-2">
        
          <?php if ( is_user_logged_in() ) { ?>
            <?php
              $user = wp_get_current_user();
              $meta = get_user_meta( $user->data->ID );

            ?>
            <li><a href="{{ App::options()['my_account'] }}">{!! pll__('My account', 'youmatter') !!}</a></li>
            <li><a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></li>

          <?php } else { ?>
            <li><a href="#" data-lightbox-open="login">{!! pll__('Login', 'youmatter') !!}</a></li>
          <?php } ?>

        </ul>
      </nav>
      <a href="{!! esc_url( home_url()) !!}/search" class="header__search">
        @include('partials.svg.search')
      </a>
      <nav class="top-menu--3">
        <ul class="menu menu--top-3">
          @if( App::options()['facebook'] )
            <li>
              <a href="{{ App::options()['facebook'] }}" target="_blank">
                @include('partials.svg.facebook')
              </a>
            </li>
          @endif
          @if( App::options()['instagram'] )
            <li>
              <a href="{{ App::options()['instagram'] }}" target="_blank">
                @include('partials.svg.instagram')
              </a>
            </li>
          @endif
          @if( App::options()['twitter'] )
            <li>
            <a href="{{ App::options()['twitter'] }}" target="_blank">
                @include('partials.svg.twitter')
              </a>
            </li>
            @endif
            @if( App::options()['linkedin'] )
            <li>
            <a href="{{ App::options()['linkedin'] }}" target="_blank">
                @include('partials.svg.linkedin')
              </a>
            </li>
            @endif
            @if( App::options()['youtube'] )
            <li>
            <a href="{{ App::options()['youtube'] }}" target="_blank" style="margin-top: 7px;">
                @include('partials.svg.youtube')
              </a>
            </li>
            @endif
            @if( App::options()['soundcloud'] )
            <li>
            <a href="{{ App::options()['soundcloud'] }}" target="_blank" style="margin-top: 7px;">
                @include('partials.svg.soundcloud')
              </a>
            </li>
            @endif
        </ul>
      </nav>
    </div>
    <nav class="header__menu">
      <a href="{{ App::homeUrl() }}" class="header__picto">
        @include('partials.svg.picto')
      </a>
      @if (has_nav_menu('main_menu'))
        {!!
          wp_nav_menu(
            array(
              'theme_location' => 'main_menu',
              'container' => false,
              'menu_class' => 'menu menu--main menu--' . App::menuAlignment()
            )
          )
        !!}
      @endif
    </nav>
  </div>
</header>
