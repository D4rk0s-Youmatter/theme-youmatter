{{--
  Template Name: Home Transitions
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.hero')
    <div class="wrapper wrapper--bg row--column">
      @include('partials.search-form')

      @if(FrontPage::getFeaturedTransitions()['items'])
      <section class="wrapper--spacer row--grid-column">
        <h2 class="title title--highlight">{!! pll__('Featured organisations') !!}</h2>
        <div class="row--grid-six">
          @foreach(FrontPage::getFeaturedTransitions()['items'] as $featured)
          @include('partials.card-transition', $featured)
          @endforeach
        </div>
      </section>
      @endif

      <section class="wrapper--spacer row--grid-column">
        @if(FrontPage::getLatestTransitions()['items'])
        <h2 class="title title--highlight">{!! pll__('You matter to these organisations:<br />they signed the Youmatter Charter') !!}</h2>
        <h3 class="title title--medium">{!! pll__('Latest signatures') !!}</h3>
        <div class="row--grid-six">
          @foreach(FrontPage::getLatestTransitions()['items'] as $latest)
          @include('partials.card-transition', $latest)
          @endforeach
        </div>
        @endif
        @if($random_transitions['items'])
        <h3 class="title title--medium">{!! pll__('All signatures') !!}</h3>
        <div class="row--grid-six">
          @foreach($random_transitions['items'] as $random)
          @include('partials.card-transition', $random)
          @endforeach
        </div>
        @endif
      </section>

      @if($chatter_title)
      <section class="wrapper--spacer row--grid-row">
        <div class="row--grid-column">
          <h3 class="title title--medium">{!! $chatter_title !!}</h3>
          <p>{!! $chatter_text !!}</p>
          @if($chatter_url)
          <a
            href="{!! $chatter_url->url !!}"
            target="{!! $chatter_url->target !!}"
            class="btn btn--blue_dark col--center-main"
          >
            {!! $chatter_url->title !!}
          </a>
          @endif
        </div>
        {!! App::get_attachment_image($chatter_image, 'medium') !!}
      </section>
      @endif

      @if($highlight_title)
      <section class="wrapper--spacer highlight">
        <h2 class="title title--white">{!! $highlight_title !!}</h2>
        <p>{!! $highlight_text !!}</p>
        @if($highlight_url)
        <a
          href="{!! $highlight_url->url !!}"
          target="{!! $highlight_url->target !!}"
          class="btn col--center-main"
        >
          {!! $highlight_url->title !!}
        </a>
        @endif
      </section>
      @endif

      @if($random_transitions['items'])
      <section class="wrapper--spacer row--grid-column" data-control="transitions">
        <h3 class="title title--highlight">{!! pll__('Discover all organizations<br/> by industry') !!}</h3>
        <form class="form form--alt js-form" novalidate>
          <input type="hidden" name="lang" value="{{ App::currentLang() }}" />
          <div class="form__row">
            <label class="screen-reader-text">
              {{ pll__('I am interested in', 'youmatter') }}
            </label>
            <select
              class="form__hidden js-sector"
              name="sector[]"
              placeholder="{!! pll__('Select an industry') !!}"
              data-empty="{!! pll__('No items found') !!}"
              multiple
            >
              @foreach(FrontPage::getTax('sector') as $sector)
              <option value="{{ $sector['id'] }}">{{ $sector['name'] }}</option>
              @endforeach
            </select>
          </div>
        </form>
        <div class="row--grid-six js-list">
          @foreach($random_transitions['items'] as $random)
          @include('partials.card-transition', $random)
          @endforeach
        </div>
        @if($random_transitions['total_pages'] > 1)
        <button class="matters__button js-more">{{ pll__('Load more') }}</button>
        @endif
      </section>
      @endif
    </div>

    @include('partials.action', [
      'title' => false,
      'sections' => ['likes', 'share']
    ])
  @endwhile
@endsection
