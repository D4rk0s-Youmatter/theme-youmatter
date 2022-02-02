<section class="action">
  @if($title)
  <h5 class="action__title">{!! pll__('<span>Your turn</span> to take action!', 'youmatter') !!}</h5>
  @endif
  <div class="action__items">
    @if($sections)

    @foreach($sections as $section)

    @switch($section)
    @case('likes')
    <section class="action__column">
      @include('partials.likes', ['layout' => 'button'])
      <span class="action__label">{!! pll__('Show how much this topic matters to you', 'youmatter') !!}</span>
    </section>
    @break
    @case('manifesto')
    <section class="action__column">
      {{-- TODO ADD MANIFESTO LINK --}}
      <a href="#" class="action__btn">
        <img src="@asset('images/sign.png')" alt="" class="action__icon" />
        {!! pll__('Sign the manifesto', 'youmatter') !!}
      </a>
      <span class="action__label">{!! pll__('Show your commitment by signing our manifesto', 'youmatter') !!}</span>
    </section>
    @break
    @case('articles')
    <section class="action__column">
      <a class="action__btn" href="{{ Category::articlesUrl() }}">
        <img src="@asset('images/article.png')" alt="" class="action__icon" />
        {!! pll__('Read articles', 'youmatter') !!}
      </a>
      <span class="action__label">{!! pll__('Get more knowledge about the major planet issues', 'youmatter') !!}</span>
    </section>
    @break
    @case('newsletter')
    <section class="action__column">
      {{-- TODO SHOW NEWSLETTER POPUP --}}
      <a href="{!!App::options()['newsletter_subscription']!!}" class="action__btn">
        <div class="action__icon action__icon--newsletter">
          @include('partials.svg.newsletter')
        </div>
        {!! pll__('Subscribe', 'youmatter') !!}
      </a>
      <span class="action__label">{!! pll__('Subscribe to our newsletter to stay up-to-date', 'youmatter') !!}</span>
    </section>
    @break
    @case('share')
    {{-- TODO ACUAL SHARING--}}
    <section class="action__column">
      @include('partials.share')
      <span class="action__label">{!! pll__('Share to raise awareness', 'youmatter') !!}</span>
    </section>
    @break
    @case('comment')
      @if( comments_open())
      <section class="action__column">
        <a href="#comments" class="action__btn" {{ App::canInteract() ? '' : 'data-lightbox-open=locked' }}>
          <div class="action__icon action__icon--comment">
            @include('partials.svg.comment')
          </div>
          {!! pll__('Comment', 'youmatter') !!}
        </a>
        <span class="action__label">{!! pll__('Share your experience with the community', 'youmatter') !!}</span>
      </section>
      @endif
    @break
    @endswitch

    @endforeach

    @endif
  </div>
</section>
