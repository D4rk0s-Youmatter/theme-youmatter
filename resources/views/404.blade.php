@extends('layouts.app')

@section('content')

@include('partials.hero')

<div class="wrapper wrapper--bg wrapper--spacer row--grid-column">
  <span class="title--small js-label">{!! pll__('Sorry, but the page you were trying to view does not exist.') !!}</span>
</div>

@endsection
