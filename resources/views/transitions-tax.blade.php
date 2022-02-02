{{--
  Template Name: Transitions tax
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.hero')
    <div class="wrapper wrapper--bg row--column">
      @if($data['items'])
      <section class="wrapper--spacer row--grid-column" data-control="transitions">
        <h3 class="title title--highlight">{!! $filter_label !!}</h3>
        @if($filters)
        <form class="form form--alt js-form" novalidate>
          <input type="hidden" name="lang" value="{{ App::currentLang() }}" />
          @foreach($filters as $filter)
          <div class="form__row">
            <label class="screen-reader-text">
              {{ pll__('I am interested in', 'youmatter') }}
            </label>
            <select
              class="form__hidden js-{{ $filter['name'] }}"
              name="{{ $filter['name'] }}[]"
              placeholder="{!! sprintf(pll__('Select a %s'), pll__($filter['name'])) !!}"
              data-empty="{!! pll__('No items found') !!}"
              multiple
            >
              @foreach($filter['items'] as $item)
              <option value="{{ $item['id'] }}">{!! $item['name'] !!}</option>
              @endforeach
            </select>
          </div>
          @endforeach
        </form>
        @endif
        <div class="row--grid-six js-list">
          @foreach($data['items'] as $random)
          @include('partials.card-transition', $random)
          @endforeach
        </div>
        @if($data['total_pages'] > 1)
        <button class="matters__button js-more">{{ pll__('Load more') }}</button>
        @endif
      </section>
      @endif

    </div>

  @endwhile
@endsection
