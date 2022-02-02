<div class="lightbox lightbox--alt" data-lightbox="locked">
  <div class="lightbox__wrapper">
    <a href="#" class="lightbox__close js-close">
      @include('./partials.svg.close')
    </a>
    <section class="lightbox__content">
      <p>{{ pll__('You are not signed in or you don’t have an account yet, that’s why you can’t express how much this topic matters to you.', 'youmatter') }}</p>
      <div class="lightbox__buttons">
        <a href="#" role="button" class="lightbox__button" data-lightbox-open="login">{!! pll__('Login', 'youmatter') !!}</a>
        <a href="#" role="button" class="lightbox__button" data-lightbox-open="register">{!! pll__('Get an account', 'youmatter') !!}</a>
      </div>
    </section>
  </div>
</div>
