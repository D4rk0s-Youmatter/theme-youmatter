<section class="jobs">
  <div class="wrapper">

    <div class="row--grid-three">
      @foreach ( TemplateJobs::getJobs() as $job)
      <div class="jobs__card">
        <h4 class="jobs__card__location">
          {{ pll__('Location', 'youmatter') }}
          <span>{!! $job['location'] !!}</span>
        </h4>
        <h2 class="jobs__card__title">{!! $job['title'] !!}</h2>
        <a href="{{ $job['link'] }}" class="jobs__card__link">{{ pll__('Read more', 'youmatter') }}</a>
      </div>
      @endforeach
</div>
  </div>
</section>
