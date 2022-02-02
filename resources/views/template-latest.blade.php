{{--
  Template Name: Latest Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.hero')

  <div
    class="wrapper wrapper--bg wrapper--spacer row--grid-column"
    data-control="latest"
  >
    <section class="row--grid-three row--grid-large js-list">
      @php $i = 1; @endphp
      @php global $post; @endphp
      @foreach ($news->posts as $post) 
        @php setup_postdata($post) @endphp
        @include('partials.card', App::getCardDetails($post, $i > 1 ? 'classique' : 'large', false))
        @php $i++; @endphp
      @endforeach
      @php wp_reset_postdata(); @endphp
    </section>
    @if($news->query_vars['paged'] < $news->max_num_pages)
    <button
      class="col--center-main btn btn--border btn--highlight-color js-more">{{ pll__('Load more', 'youmatter') }}</button>
    @endif
    
  </div>
@endsection
