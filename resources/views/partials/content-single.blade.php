<article class="article">
  @if(get_post_type() !== 'jobs')
    @include('partials.author')
  @endif
  <div class="article__wrap">
    <div class="article__content">
      <p class="article__date">{!!$date!!}</p>
      @php the_content() @endphp
      @if ( get_current_blog_id() === 3 && App::options()['show_donations'])
        @include('partials.donation')
      @endif
    </div>
    <footer class="article__footer">
      <!-- @include('partials.likes', ['layout' => 'default']) -->
      @include('partials.discover', [
        'title' => false,
        'items' => $article_category,
        'layout' => 'small'
      ])
    </footer>
  </div>
</article>
@include('partials.action', [
  'title' => true,
  'sections' => ['likes', 'share', 'comment', 'newsletter']
])
@include('partials.related')


