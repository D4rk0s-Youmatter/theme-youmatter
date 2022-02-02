<a href="{{ $article['url'] }}" class="card card--simple">
  <div class="card__figure">
    <img src="{!! $article['image'] !!}" alt="{!! $article['title'] !!}">
  </div>
  <div class="card__content">
    <h3 class="card__title">{!! $article['title'] !!}</h3>
    <h4 class="card__author">{!! pll__('by', 'youmatter') !!} {!! $article['org'] !!}</h4>
  </div>
</a>
