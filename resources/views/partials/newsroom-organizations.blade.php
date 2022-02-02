@if($organizations_title)
<div class="newsroom-organization wrapper wrapper--bg wrapper--spacer row--grid-column">
  <h2 class="title title--bold">{!! $organizations_title !!}</h2>
  <div class="row--grid-three row--grid-large js-list">
    @foreach (App::getFeaturedCompanies(6) as $company)
      <a href="#" class="company__card" data-lightbox-open="orgLogo">
        <div class="company__card__box">
          <div class="company__card__logo">
            <div>
              <img src="{!! $company['thumb'] !!}" alt="{!! $company['title'] !!}">
            </div>
          </div>
        </div>
        <div class="newsroom-organization__date">Date: {!! $company['date'] !!}</div>
      </a>
    @endforeach
  </div>
  <button
      class="col--center-main btn btn--border btn--highlight-color js-more">{{ pll__('Load more', 'youmatter') }}</button>
</div>
@include ('partials.popin-org-logo')
@endif
