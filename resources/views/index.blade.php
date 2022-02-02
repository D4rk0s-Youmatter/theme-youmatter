@extends('layouts.app')

@section('content')
@include('partials.hero')

<div
  class="wrapper wrapper--bg wrapper--spacer row--grid-column"
  data-control="archive"
>
  @if (have_posts())
  <span class="title--small js-label">{{ sprintf(pll__('%d articles found', 'youmatter'), $articles_count) }}</span>
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
@endsection
