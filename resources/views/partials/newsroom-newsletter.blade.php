<section class="home--sixth home--sixth--light">
  <div class="wrapper">
    <div class="row">
      <div class="svg">
        @include('partials.svg.picto')
      </div>
      <h3 class="home--sixth__subtitle home--sixth--light__subtitle col-xs-12">
        {!! $newsletter_title !!}
        <span>
          {!! $newsletter_subtitle !!}
        </span>
      </h3>
      <p>{!! $newsletter_content !!}</p>
    </div>
    <div class="row">
      <div class="col-lg-12">

        {!! do_shortcode(App::echo_shortcode($newsletter_shortcode)) !!}
      </div>
    </div>
  </div>
</section>