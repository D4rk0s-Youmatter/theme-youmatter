<section class="home--first" style="background-image: url(@asset('images/bg-s1.png'))">
  <div class="wrapper">
    <div class="row">
      <div class="col col-12 col-md-7">
        <h1>
          {!! $first_section_title !!}
          <span>{!! $first_section_subtitle !!}</span>
        </h1>
        <div class="home--first_text">
          {!! $first_section_text !!}
        </div>
        @if($first_section_button_link)
          <div class="link">
            <a href="{!! $first_section_button_link !!}" class="btn btn--blue_dark btn--arrow" target="_blank">{!! $first_section_button_label !!}</a>
          </div>
        @endif
        @php $pageviews = App::pageviews() @endphp
        <div class="home--first_figures" data-control="FIGURES">
          <h3>{{ pll__('Citizens informed so far', 'youmatter') }}</h3>
          <ul class="home--first_figures_values row">
            <li class="col col-4">
              <div data-value="{{ $pageviews['current'] }}"><i>0</i></div>
              <span>{{ pll__('this month', 'youmatter') }}</span>
            </li>
            <li class="col col-4">
              <div data-value="{{ $pageviews['previous'] }}"><i>0</i></div>
              <span>{{ pll__('last month', 'youmatter') }}</span>
            </li>
            <li class="col col-4">
              <div data-value="{{ $pageviews['difference'] }}" data-operator="{{ $pageviews['operator'] }}"><i>0</i>%</div>
              <span>{{ pll__('since last month', 'youmatter') }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="home--first__animation">
    @include('partials.svg.animhome1')
  </div>
</section>
