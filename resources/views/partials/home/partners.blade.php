@php
    $orgcount = App::getOrganizationsCount();
    $organizations_formatted_title = str_replace("[number]", $orgcount, $organizations_title);
@endphp

<section class="home--partners">
    <div class="wrapper">
        <h2 class="home--partners_title">{{ $organizations_formatted_title }}</h2>
        <div class="home--partners_link"><a href="{!! $organizations_button_link !!}" class="btn btn--fill btn--violet home--partners_link_btn">{!! $organizations_button_text !!}</a></div>
        <div class="row--grid-four home--partners_list">
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
    </div>
</section>