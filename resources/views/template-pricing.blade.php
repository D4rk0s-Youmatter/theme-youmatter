{{--
  Template Name: Services Pricing
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.hero')

    @if($options)
    <section class="comparison">
      @foreach($options as $option)
        <article class="comparison__item">
          <h2 class="title title--spacer">{!! $option->title !!}</h2>
          <ul class="comparison__list">
            @foreach($option->features as $feature)
            <li class="comparison__text {{ $feature->enabled ? 'enabled' : ''}}">{!! $feature->text !!}</li>
            @endforeach
          </ul>
          @if($option->button)
          <a
            href="{!! $option->button->url !!}"
            target="{!! $option->button->target !!}"
            class="btn btn--fill"
          >
            {!! $option->button->title !!}
          </a>
          @endif
        </article>
      @endforeach
    </section>
    @endif

    <div class="home--light">
    @if($features)
      @foreach($features as $key => $feature)
        <article class="wrapper wrapper--spacer row--grid-row">
          @if($key % 2 != 0)
          {!! wp_get_attachment_image($feature->image, 'medium', false, ['class' => 'cover']) !!}
          @endif
          <div class="row--grid-column">
            <h2 class="title title--highlight">{!! $feature->title !!}</h2>
            <p>{!! $feature->text !!}</p>
          </div>
          @if($key % 2 == 0)
          {!! wp_get_attachment_image($feature->image, 'medium', false, ['class' => 'cover']) !!}
          @endif
        </article>
      @endforeach
    @endif
    </div>

  @endwhile
@endsection
