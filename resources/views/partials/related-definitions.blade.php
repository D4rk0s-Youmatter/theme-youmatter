@if($related_definitions)
<section class="related">
  <h5 class="related__title">{{ pll__('related definitions', 'youmatter') }}</h5>
  <div class="related__items">
    @foreach($related_definitions as $article)
    @include('partials.card', App::getCardDetails($article, 'classique', false))
    @endforeach
  </div>
</section>
@endif
