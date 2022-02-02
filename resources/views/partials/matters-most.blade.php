<section
  class="home--third home--{{ $layout }}"
  data-control="matters"
  data-cat="{{ Category::categoryId() }}"
>
  <div class="wrapper row--grid-column">
    <div class="row">
      <div class="col-lg-9">
        <h3 class="home--third__subtitle">
          {!! Frontpage::thirdSectionTitle() !!}<br>
          {!! Frontpage::thirdSectionSubtitle() !!}
        </h3>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-9">
        <div class="home--third_text">
          {!! Frontpage::thirdSectionText() !!}
        </div>
      </div>
    </div>

    <div class="row--grid-three js-list">
      @foreach( App::likedArticlesList()['articles'] as $article )
      @include('partials.card', $article )
      @endforeach
    </div>

    @if(App::likedArticlesList()['total_pages'] > App::likedArticlesPage())
    <button
      class="matters__button js-more"
      data-cat="{{ Category::categoryId() }}"
    >
      {{ pll__('Load more', 'youmatter') }}
    </button>
    @endif

  </div>
</section>
