<div class="lightbox lightbox--login" data-lightbox="login">
  <div class="lightbox__wrapper">
    <a href="#" class="lightbox__close js-close">
      @include('./partials.svg.close')
    </a>

    <section class="lightbox__content">
      <h2 class="title title--bold">{!! App::options()['login_main_screen_title_bold'] !!} <span>{!! App::options()['login_main_screen_title_light'] !!}</span></h2>
      <p>{!! App::options()['login_text'] !!}</p>
      <div class="lightbox__buttons">
        <a href="#" class="lightbox__button" data-lightbox-open="login-email">{{ pll__('Login with your email', 'youmatter') }}</a>
        @php do_action('oa_social_login') @endphp
      </div>
      <footer>
        @if ( !App::canInteract() )
          <p>{{ pll__('You don’t have an account yet?', 'youmatter') }} <a href="#" data-lightbox-open="register">{{ pll__('Sign up here!', 'youmatter') }}</a></p>
        @endif
        <p>{{ pll__('You forgot your password?', 'youmatter') }} <a href="#" data-lightbox-open="reset-pass">{{ pll__('Click here', 'youmatter') }}</a></p>
        <p>
          {{ pll__('By logging in, you accept Youmatter', 'youmatter') }} <a href="{!! App::options()['terms_and_conditions_link'] !!}">{{ pll__('Conditions of Use', 'youmatter') }}</a>
          {{ pll__('and', 'youmatter') }} <a href="{!! App::options()['privacy_policy'] !!}">{{ pll__('Privacy Policy', 'youmatter') }}</a>
        </p>
      </footer>

    </section>
  </div>
</div>
