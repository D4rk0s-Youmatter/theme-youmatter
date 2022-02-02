{{--
    Template Name: Home Template
    --}}
  
  @extends('layouts.app')

  
  @section('content')
  <div class="home" data-control="home">
    @while(have_posts()) @php the_post() @endphp
  
      @include('partials.home.hero')
      @include('partials.home.stats')
      @include('partials.home.recents')
      @include('partials.home.read')
      @include('partials.home.crucials')
      @include('partials.home.themes')
      @include('partials.home.partners')

    @endwhile
  </div>
  @endsection