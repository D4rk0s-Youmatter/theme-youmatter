<a href="{{ $url }}" class="card card--{{ $layout }}">
  <div class="card__figure">
    {!! $image !!}
    @if(App::displayCardMeta($id, $layout))
    <div class="card__likes">
      @include('partials.svg.picto')
      {{ $likes }}
    </div>
    @endif
  </div>
  <div class="card__content">
    @if(App::displayCardCategoryTop($id, $layout) && $cats)
    <h4 class="card__categories">{!! $cats !!}</h4>
    @endif
    <h3 class="card__title">{!! $title !!}</h3>
    @if(isset($excerpt) && $excerpt)
    <p class="card__excerpt">{!! $excerpt !!}</p>
    @endif
    @if(App::displayCardDetails($id, $layout))
    <h4 class="card__author">{!! pll__('by', 'youmatter') !!} {!! App::getAuthor($author) !!}</h4>
    @endif
    @if(App::displayCardMeta($id, $layout))
    <footer class="card__footer">
      @if($cats)
        <h4 class="card__categories">{!! $cats !!}</h4>
      @endif
      <div>

        @if($content)
        <p class="card__reading">{!! App::getReadingTime($content) !!}
          {!! pll__('min to read', 'youmatter') !!}</p>
        @endif
      </div>
      @if($time)
      <div>
        <time class="card__date">{!! App::timeElapsedSstring($time, FALSE) !!}</time>
      </div>
      @endif
    </footer>
    @endif
    @if(App::displayCardMore($id, $layout))
    <span class="card__more">{!! pll__('Read more', 'youmatter') !!}</span>
    @endif
  </div>
</a>
