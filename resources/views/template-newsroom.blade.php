{{--
  Template Name: Newsroom Template
--}}

@extends('layouts.app')

@section('content')
  <div class="newsroom">
    @while(have_posts()) @php the_post() @endphp
      @include('partials.hero')
      @include('partials.press')
      @include('partials.newsroom-newsletter')
      @include('partials.newsroom-organizations')
      @include('partials.newsroom-contact')

    @endwhile
  </div>
@endsection
