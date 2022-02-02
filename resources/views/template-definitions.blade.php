{{--
  Template Name: Definitions Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.hero')
    @include('partials.definitions')
  @endwhile
@endsection
