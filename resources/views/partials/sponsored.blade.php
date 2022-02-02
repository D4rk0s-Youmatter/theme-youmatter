@if($sponsored_articles)
<section class="sponsored">
  <h5 class="sponsored__title">{{ pll__('Sponsored articles', 'youmatter') }}</h5>
  @if($column)
  <div class="sponsored__items--column">
  @else
  <div class="sponsored__items">
  @endif
    @foreach($sponsored_articles as $article)
      @include('partials.card-sponsored', $article)
    @endforeach
  </div>
</section>
@endif
