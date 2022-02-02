<section class="home--second">
  <div class="wrapper">
    <div class="row">
      <div class="col-lg-7">
        <h2 class="home--second__title">
          {!! $second_section_title !!}<br>
          {!! $second_section_subtitle !!}
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-7">
        @if($second_section_text)
          <div class="home--second_text">{!! $second_section_text !!}</div>
        @endif
        <h3 class="home--second__subtitle">
          {!! $second_section_secondary_title !!}<br>
          <span>{!! $second_section_secondary_subtitle !!}</span>
        </h3>

        <div class="home--second_secondary_text">{!! $second_section_secondary_text !!}</div>

      </div>
      <div class="col-lg-5">
         <a href="{!! $second_section_button_link !!}" class="btn btn--fill">{!! $second_section_button_label !!}</a> 
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="row--grid-three home--second__temporary">
          @foreach( App::latestArticlesList()['articles'] as $article )
            @include('partials.card', $article )
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>
