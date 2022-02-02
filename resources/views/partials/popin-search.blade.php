<div class="lightbox lightbox--search" data-lightbox="search">
  <div class="lightbox__wrapper">
    <a href="#" class="lightbox__close js-close">
      <!-- //TODO replace with svg -->
      <img src="@asset('images/close.png')" alt="close">
    </a>

    <section class="lightbox__content">
      <header>
        <h2 class="title title--bold">Search <span>our website</span></h2>
        <p>{!! App::options()['login_text'] !!}</p>
      </header>
      <div class="lightbox__buttons">
        @php get_search_form() @endphp
      </div>
    </section>
  </div>
</div>
