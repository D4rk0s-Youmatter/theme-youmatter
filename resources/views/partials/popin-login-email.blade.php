<div class="lightbox" data-lightbox="login-email">
  <div class="lightbox__wrapper">
    <a href="#" class="lightbox__close js-close">
      @include('./partials.svg.close')
    </a>

    <section class="lightbox__content">
      <h2 class="title title--bold">Welcome <span>back</span></h2>
      <p>{!! App::options()['login_text'] !!}</p>
      <div class="lightbox__buttons">
        @php
          if ( !App::canInteract() ) {
            $args = array(
              'label_username' => pll__( 'your username', 'youmatter' ),
              'label_password' => pll__( 'your password', 'youmatter' ),
              'label_log_in' => pll__( 'Log in', 'youmatter' ),
              'redirect' => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
              'remember' => false
              );
            wp_login_form( $args );
          } else {
            wp_loginout( home_url() );
          }
        @endphp
      </div>
      <footer>
        <p>{{ pll__('You don’t have an account yet?', 'youmatter') }} <a href="#" data-lightbox-open="register">{{ pll__('Sign up here!', 'youmatter') }}</a></p>
        <p>{{ pll__('You forgot your password?', 'youmatter') }} <a href="#" data-lightbox-open="forgot-pass">{{ pll__('Click here', 'youmatter') }}</a></p>
        <p>
          {{ pll__('By logging in, you accept Youmatter', 'youmatter') }} <a href="{!! App::options()['terms_and_conditions_link'] !!}">{{ pll__('Conditions of Use', 'youmatter') }}</a>
          {{ pll__('and', 'youmatter') }} <a href="{!! App::options()['privacy_policy'] !!}">{{ pll__('Privacy Policy', 'youmatter') }}</a>
        </p>
      </footer>

    </section>
  </div>
</div>
