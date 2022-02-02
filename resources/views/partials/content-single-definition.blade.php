<article class="article">

  <div class="article__wrap">
    <div class="article__content">
      @php the_content() @endphp
      @if ( get_current_blog_id() === 3 && App::options()['show_donations'])
        @include('partials.donation')
      @endif
    </div>
    <footer class="article__footer">
      @include('partials.likes', ['layout' => 'default'])
      @include('partials.discover', [
        'title' => false,
        'items' => [
          [
            'image' => null,
            'title' => pll__('Go to definitions', 'youmatter'),
            'url' => \App::options()['definition_page_url']
          ]
        ],
        'layout' => 'small'
      ])
      @include('partials.sponsored',['column' => true])
    </footer>
  </div>
</article>

@include('partials.action', [
  'title' => true,
  'sections' => ['likes', 'share', 'comment', 'newsletter']
])
@php comments_template('/partials/comments.blade.php') @endphp

@include('partials.related-definitions')
