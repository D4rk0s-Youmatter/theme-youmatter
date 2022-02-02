@extends('layouts.app')

@section('content')
@include('partials.hero')

<div
  class="wrapper wrapper--bg wrapper--spacer row--grid-column"
  data-control="archive"
>
  <form class="form form--alt js-form" novalidate>
    <input type="hidden" name="lang" value="{{ App::currentLang() }}" />
    <div class="form__row">
      <label class="form__label">{{ pll__('I am interested in', 'youmatter') }}</label>
      <select
        class="form__hidden js-choice-category"
        name="subcategory[]"
        multiple
        placeholder="{!! pll__('Select your interest(s)', 'youmatter') !!}"
        data-empty="{!! pll__('No items found', 'youmatter') !!}"
      >
        @if($subcategories)
        @foreach($subcategories as $subcategory)
        <option value="{{ $subcategory['id'] }}">{!! $subcategory['name'] !!}</option>
        @endforeach
        @endif
      </select>
    </div>
    <div class="form__row">
      <label class="form__label">{{ pll__('and looking for', 'youmatter') }}</label>
      <select
        class="form__hidden js-choice-tag"
        name="tag[]"
        multiple
        placeholder="{!! pll__('Select your interest(s)', 'youmatter') !!}"
        data-empty="{!! pll__('No items found', 'youmatter') !!}"
      >
        @if($tags)
        @foreach($tags as $tag)
        <option value="{{ $tag['id'] }}">{{ $tag['name'] }}</option>
        @endforeach
        @endif
      </select>
    </div>
    <input type="hidden" name="category" value="{{ Category::categoryId() }}" />
    <button type="submit" class="form__submit">{{ pll__('Filter', 'youmatter') }}</button>
  </form>
  @if (have_posts())
  <span
    class="title--small js-label">{{ sprintf(pll__('%d articles found', 'youmatter'), $articles_count) }}</span>
  <section class="row--grid-three row--grid-large js-list">
    @php $i = 1; @endphp
    @php global $post; @endphp
    @while (have_posts()) @php the_post() @endphp
    @include('partials.card', App::getCardDetails($post, $i > 1 ? 'classique' : 'large', false))
    @php $i++; @endphp
    @endwhile
  </section>
  @if($articles_pages_count > $articles_page)
  <button
    class="col--center-main btn btn--border btn--highlight-color js-more">{{ pll__('Load more', 'youmatter') }}</button>
  @endif
  @else
  <span
    class="title--small js-label">{{ pll__('No articles were found.', 'youmatter') }}</span>
  @endif
</div>
<!-- @include('partials.newsletter', ['layout' => 'large']) -->
@endsection
