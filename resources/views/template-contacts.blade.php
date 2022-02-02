{{--
  Template Name: Contacts Template
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.hero')
    @include('partials.content-page')
    <section class="wrapper wrapper--spacer row--two-thirds">
      @include('partials.contacts')
      @if($team_details)
      @include('partials.team', $team_details)
      @endif
    </section>
  @endwhile
@endsection
