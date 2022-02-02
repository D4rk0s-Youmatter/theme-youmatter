<div class="lightbox" data-lightbox="reset-pass">
  <div class="lightbox__wrapper">
    <a href="#" class="lightbox__close js-close">
      @include('./partials.svg.close')
    </a>

    <section class="lightbox__content">
      <h2 class="title title--bold">{!! pll__('Forgot Your Password?', 'youmatter') !!}</h2>
      @if ( !App::canInteract() )
        <p>{!! pll__("Enter your email address and we'll send you a link you can use to pick a new password.","youmatter") !!}</p>
        <div class="form lightbox__buttons" data-control="reset">
          <p class="message hidden"></p>
          <form>
            <p class="form_row">
              <label class="form__label" for="user_login">{!! pll__( "Email", "youmatter" ); !!}</label>
              <input type="email" name="user_login" id="user_login" class="form__field" />
            </p>
            <p class="lostpassword-submit">
              <button type="submit" class="btn">{!! pll__( 'Reset Password', 'youmatter' ) !!}</a>
            </p>
          </form>
        @else:
          <p>{!! pll__("You are already logged in.","youmatter") !!}</p>
        @endif
      </div>
    </section>
  </div>
</div>