<section class="home--fifth">
  <div class="wrapper">
    <div class="row">
      <div class="col-lg-7">
        <h3 class="home--fifth__subtitle">
          {!! $fifth_section_title !!}<br>
          {!! $fifth_section_subtitle !!}
        </h3>
        <div class="home--fifth_text">{!! $fifth_section_text !!}</div>
        <!-- <div class="home--fifth_link col-lg-5">
          <a href="{!! $fifth_section_link !!}" class="btn btn--violet">{!! $fifth_section_link_label !!}</a>
        </div> -->
      </div>
    </div>

    <!-- <div class="row">
      <div class="col-lg-7">
        <h3 class="home--fifth__secondary_subtitle">
          {!! $fifth_section_secondary_title !!}
          <span>
            {!! $fifth_section_secondary_subtitle !!}
          </span>
        </h3>
      </div>
      <div class="col-lg-5">
        <div class="home--fifth_secondary_text">{!! $fifth_section_secondary_text !!}</div>
        <div class="home--fifth_secondary_link col-lg-5">
          <a href="{!! $fifth_section_secondary_link !!}" class="btn btn--violet-inverted">{!! $fifth_section_secondary_link_label !!}</a>
        </div>
      </div>
    </div> -->

    <div class="row">
      <h3 class="home--fifth__tertiary_subtitle">
        {!! App::getOrganizationsCount() !!} {!! $fifth_section_tertiary_title !!}
        <span>
          {!! $fifth_section_tertiary_subtitle !!}
        </span>
      </h3>
    </div>

    <div class="row--grid-four">
      @foreach (App::getFeaturedCompanies(4) as $company)
        <div class="company__card">
          <div class="company__card__box">
            <a href="{!!$company['link']!!}">
              <div class="company__card__logo">
                <div>
                  <img src="{!! $company['thumb'] !!}" alt="{!! $company['title'] !!}">
                </div>
              </div>
              <div class="company__card__title">{!! $company['title'] !!}</div>
            </a>
          </div>
        </div>
      @endforeach
    </div>

    <div class="row">
      <div class="home--fifth_tertiary_link col-lg-5">
        <a href="{!! $fifth_section_tertiary_link !!}" class="btn btn--violet-inverted">{!! $fifth_section_tertiary_link_label !!}</a>
      </div>
    </div>



  </div>
</section>
