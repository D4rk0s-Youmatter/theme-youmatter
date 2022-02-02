@extends('layouts.app')

@section('content')
@include('partials.hero')

<section class="wrapper wrapper--bg wrapper--spacer-bottom row--grid-column" data-control="search">
  @include('partials.search-form')
  <span class="title--small js-label">
    {!! $search_results['items_label'] !!}
  </span>
  @if ($search_results['items'])
  <div class="row--grid-three js-list" data-search="{!! $search_term !!}">
    @foreach($search_results['items'] as $item)
    {!! $item !!}
    @endforeach
  </div>
  @if($search_results['total_pages'] > $current_page)
  <button
    class="col--center-main btn btn--border btn--highlight-color js-more">{{ pll__('Load more', 'youmatter') }}</button>
  @endif
  @endif

</section>
@endsection
