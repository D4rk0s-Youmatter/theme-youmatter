{{--
  Template Name: Jobs Template
--}}

@extends('layouts.app')

@section('content')
  <div class="jobs">
    @while(have_posts()) @php the_post() @endphp
      @include('partials.hero')
      @include('partials.jobs')
      @include('partials.management')
    @endwhile
  </div>
@endsection
