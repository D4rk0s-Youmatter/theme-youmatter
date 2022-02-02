{{--
  Template Name: Home Services
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.hero-services', ['anim' => true ])

    @if($purpose_title)
    <section class="matters wrapper--spacer" data-control="expandable">
      <h2 class="title title--bold title--highlight">{!! $purpose_title !!}</h2>
      <div class="matters__text js-expandable">{!! $purpose_text !!}</div>
      <button class="matters__button js-expand">{{ pll__('Load more') }}</button>
      @if($purpose_video)
      @include('partials.video', ['video_id' => $purpose_video])
      @endif
    </section>
    @endif

    <div class="home--light violet">
    @if($chatter_title)
    <section class="wrapper row--grid-two wrapper--spacer">
      <header>
        <h2 class="title title--bold title--spacer title--violet">{!! $chatter_title !!}</h2>
        <div class="title title--small">{!! $chatter_subtitle !!}</div>
      </header>
      <article class="col--full row--grid-row">
        {!! wp_get_attachment_image($chatter_image, 'large', false) !!}
        <div class="row--grid-column">
          <p>{!! $chatter_text !!}</p>
          @if($chatter_btns)
          <footer class="col--start-main row--grid-column">
            @foreach($chatter_btns as $key => $item)
              <a
                href="{!! $item->btn->url !!}"
                target="{!! $item->btn->target !!}"
                class="btn  btn--violet {{ $key % 2 == 0 ? '' : 'btn--violet-inverted' }}"
              >
                {!! $item->btn->title !!}
              </a>
            @endforeach
          </footer>
          @endif
        </div>
      </article>
      <footer class="row--grid-column col--full">
        <h5 class="title">
          <strong class="title--violet">{{ FrontPage::getTotalTransitions() }}</strong> <span class="title--medium">{!! pll__('signatories so far, here are the latest', 'youmatter') !!}</span>
        </h5>
        <div class="row--grid-four">
          @foreach(FrontPage::getLatestTransitions(4)['items'] as $latest)
          @include('partials.card-transition', $latest)
          @endforeach
        </div>
      </footer>
    </section>
    @endif
    </div>

    <div class="home--light">
    @if($community_title)
    <section class="wrapper row--grid-column">
      <article class="row--grid-row wrapper--spacer">
        <div class="row--grid-column">
          <h3 class="title">{!! $community_title !!}</h3>
          <p>{!! $community_text !!}</p>
          @if($community_btns)
          <footer class="col--start-main row--grid-column">
            @foreach($community_btns as $key => $item)
              <a
                href="{!! $item->btn->url !!}"
                target="{!! $item->btn->target !!}"
                class="btn {{ $key % 2 == 0 ? 'btn--fill' : 'btn--border btn--highlight-color' }}"
              >
                {!! $item->btn->title !!}
              </a>
            @endforeach
          </footer>
          @endif
        </div>
        {!! wp_get_attachment_image($community_image, 'large', false) !!}
      </article>
    </section>
    @endif

    @if($advertise_title)
    <section class="wrapper wrapper--spacer highlight--alt">
      {!! wp_get_attachment_image($advertise_image, 'large', false, ['class' => 'highlight__image']) !!}
      <div class="highlight__content">
        <h4 class="highlight__title">{!! $advertise_title !!}</h4>
        <p class="highlight__text">{!! $advertise_text !!}</p>
        @if($advertise_btns)
        <footer class="col--start-main row--grid-column">
          @foreach($advertise_btns as $key => $item)
            <a
              href="{!! $item->btn->url !!}"
              target="{!! $item->btn->target !!}"
              class="btn btn--border"
            >
              {!! $item->btn->title !!}
            </a>
          @endforeach
        </footer>
        @endif
      </div>
    </section>
    @endif

    </div>

    <div class="wrapper wrapper--spacer row--column">
    @if($solutions_title)
    <section class="wrapper--spacer row--grid-column">

      <header>
        <h2 class="title title--bold title--spacer">{!! $solutions_title !!}</h2>
        <div class="title title--small">{!! $solutions_subtitle !!}</div>
      </header>
      <article class="col--full row--grid-row">
        {!! wp_get_attachment_image($solutions_image, 'large', false, ['class' => 'cover']) !!}
        <div class="row--grid-column">
          <p>{!! $solutions_text !!}</p>
        </div>
      </article>

      @if($solutions_list)
        <div class="row--grid-two">
        @foreach($solutions_list as $item)
          <article class="row--grid-row">
            {!! wp_get_attachment_image($item->image, 'thumbnail', false) !!}
            <div class="row--grid-column">
              <h5 class="title title--small">{!! $item->title !!}</h5>
              <p>{!! $item->text !!}</p>
            </div>
          </article>
        @endforeach
        </div>
      @endif
    </section>
    @endif

    @if(FrontPage::getFeaturedTransitions(4)['items'])
    <section class="wrapper--spacer row--grid-column">
      <h2 class="title">{!! pll__('They trust Youmatter') !!}</h2>
      <div class="row--grid-four">
        @foreach(FrontPage::getFeaturedTransitions(4)['items'] as $featured)
        @include('partials.card-transition', $featured)
        @endforeach
      </div>
    </section>
    @endif

    @if($highlight)
      <footer class="row--grid-column">
        <a
          href="{!! $highlight->url !!}"
          target="{!! $highlight->target !!}"
          class="col--center-main btn btn--fill"
        >
          {!! $highlight->title !!}
        </a>
      </footer>
    @endif
  </div>

  @endwhile
@endsection
