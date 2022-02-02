<div class="lightbox" data-lightbox="register">
  <div class="lightbox__wrapper">
    <a href="#" class="lightbox__close js-close">
      @include('./partials.svg.close')
    </a>

    <section class="lightbox__content lightbox__register">
      <h2 class="title title--bold">{!! pll__('Registration', 'youmatter') !!}</h2>
      <div class="form lightbox__buttons" data-control="register">
        <p class="message hidden"></p>
        <form>
          <p class="form_row">
            <label class="form__label" for="user_login">{!! pll__( 'Email', 'youmatter' ); !!}</label>
            <input required type="email" name="user_login" id="user_login" placeholder="{!! pll__( 'Email', 'youmatter' ); !!}" class="form__field" />
          </p>
          <p class="form_row">
            <label class="form__label" for="password">{!! pll__( 'Password', 'youmatter' ); !!}</label>
            <input required pattern=".{8,}" title="{!! pll__('At least 8 characters', 'youmatter') !!}" type="password" name="password" id="password" placeholder="{!! pll__( 'Password', 'youmatter' ); !!}" class="form__field" />
          </p>
          <p class="form_row">
            <label class="form__label" for="first_name">{!! pll__( 'First Name', 'youmatter' ); !!}</label>
            <input required type="text" name="first_name" id="first_name" placeholder="{!! pll__( 'First Name', 'youmatter' ); !!}" class="form__field" />
          </p>
          <p class="form_row">
            <label class="form__label" for="last_name">{!! pll__( 'Last Name', 'youmatter' ); !!}</label>
            <input required type="text" name="last_name" id="last_name" placeholder="{!! pll__( 'Last Name', 'youmatter' ); !!}" class="form__field" />
          </p>
          <p class="lostpassword-submit">
            <button type="submit" class="btn">{!! pll__( 'Submit', 'youmatter' ) !!}</a>
          </p>
        </form>
        
      </div>
    </section>
  </div>
</div>