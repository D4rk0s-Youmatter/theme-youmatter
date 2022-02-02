{{--
  Template Name: About Template
--}}

@extends('layouts.app')

@section('content')
  <div class="about">
    @while(have_posts()) @php the_post() @endphp
      @include('partials.hero-video')
      @include('partials.about')
    @endwhile
  </div>
@endsection
