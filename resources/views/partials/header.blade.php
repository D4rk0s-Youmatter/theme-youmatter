<?php
  $siteLanguage = get_bloginfo('language');
  $languageShort= explode('-',$siteLanguage);

  $siteURL = get_site_url(2);

?>

<header class="header bg-grey" data-control="header">
      <div class="header__blue-banner">
            <div class="msg-blue-banner">
                <div id="msg-banner">@include('partials.header-messages')</div>
            </div> <!-- .msg-blue-banner -->
            <div class="header__aside">
                <nav class="top-menu--3">
                    <ul class="menu menu--top-3">
                      @if( App::options()['facebook'] )
                        <li>
                          <a href="{{ App::options()['facebook'] }}" target="_blank">
                            @include('partials.svg.facebook')
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
                      @if( App::options()['instagram'] )
                        <li>
                          <a href="{{ App::options()['instagram'] }}" target="_blank">
                            @include('partials.svg.instagram')
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
                    </ul> <!-- .menu--top-3 -->
                  </nav>
            </div> <!-- .header__aside -->
      </div><!-- .header__blue-banner -->
      <div class="wrapper header__bruce-banner">
        <button
        class="header__burger js-burger"
        data-label-open="{!! pll__('Menu', 'youmatter') !!}"
        data-label-closed="{!! pll__('Menu', 'youmatter') !!}"
      >
        <span class="screen-reader-text">{!! pll__('Menu', 'youmatter') !!}</span>
      </button>
        <div class="header__main-banner">
            @include('partials.header-searchform')
          <a href="{{ App::homeUrl() }}" class="header__logo">
            {!! App::get_attachment_image(App::options()['logo_id'], 'medium') !!}
          </a>
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
    </div><!-- .bruce-banner -->
</div><!-- .header__main-banner -->
<div class="header__wrap banner-menu">
    <nav class="header__menu js-scroll-offset">
      @if (has_nav_menu('main_menu'))
        {!!
          wp_nav_menu(
            array(
              'theme_location' => 'main_menu',
              'container' => false,
              'menu_class' => 'menu menu-header menu--main menu--' . App::menuAlignment()
            )
          )
        !!}
      @endif
      <ul class="menu menu-header menu--main menu--secondary">
        <!--<li class="menu-item">-->
            <!--<a href="#">Par secteur</a>-->
            @if (has_nav_menu('sectors_menu'))
            {!!
              wp_nav_menu(
                array(
                  'theme_location' => 'sectors_menu',
                  'container' => false,
                  'menu_class' => 'menu menu-header menu--sectors menu--' . App::menuAlignment()
                )
              )
            !!}
          @endif
        <!--</li> -->
        <!--<li class="menu-item">-->
            <!--<a href="#">Nos services</a>-->
            @if (has_nav_menu('services_menu'))
            {!!
              wp_nav_menu(
                array(
                  'theme_location' => 'services_menu',
                  'container' => false,
                  'menu_class' => 'menu menu-header menu--services menu--' . App::menuAlignment()
                )
              )
            !!}
          @endif
        <!--</li>-->
      </ul>
    </nav> <!-- .header__menu -->
  </div> <!-- .wrapper -->
</header>


{{-- 
TODO @jerem = finaliser la fonction GetSectors
    App::GetSectors() 
    
--}}