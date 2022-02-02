<article class="article article--organisations">
  <div class="article__wrap">
    @include ('partials.tabs')
  </div>
</article>

@include('partials.action', [
  'title' => false,
  'sections' => ['likes', 'share']
])
