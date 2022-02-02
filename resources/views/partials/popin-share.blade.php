<div class="lightbox lightbox--alt" data-lightbox="share">
  <div class="lightbox__wrapper">
    <a href="#" class="lightbox__close js-close">
      @include('./partials.svg.close')
    </a>
    <section class="lightbox__content">
      <p>{{ pll__('Share this article', 'youmatter') }}</p>
      <div class="lightbox__buttons">
        <div class="getsocial gs-inline-group"></div>{{-- DIV FROM GETSOCIAL EMBED --}}
        {!! App::shareScript() !!}
      </div>
    </section>
  </div>
</div>
