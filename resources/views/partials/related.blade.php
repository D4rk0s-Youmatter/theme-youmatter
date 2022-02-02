@if($related_articles)
<section class="related">
  <h5 class="related__title">{{ pll__('related articles', 'youmatter') }}</h5>
  <div class="related__items">
    @foreach($related_articles as $article)
    @include('partials.card', App::getCardDetails($article, 'classique', false))
    @endforeach
  </div>
</section>
@endif
