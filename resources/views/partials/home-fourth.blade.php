<section class="home--fourth">
  <div class="home--fourth__animation">
    @include('partials.svg.animhome2')
  </div>
  <div class="wrapper">
    <div class="row">
      <div class="col-lg-7">
        <h3 class="home--fourth__subtitle">
          {!! $fourth_section_title !!}<br>
          {!! $fourth_section_subtitle !!}
        </h3>
      </div>
    </div>

    <div class="row--grid-three">
      @if ( !empty( Frontpage::getCategories() ) )
        @foreach ( Frontpage::getCategories() as $term )
          @include('partials.category-card', $term )
        @endforeach
      @endif
    </div>

  </div>
</section>
