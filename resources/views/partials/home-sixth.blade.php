<section class="home--sixth" style="background-image: url(@asset('images/bg-s6.png'))">
  <div class="home--sixth__animate">
    @include('partials.svg.animhome3')
  </div>
  <div class="wrapper">
    <div class="row">
      <h3 class="home--sixth__subtitle col-xs-12">
        {!! $sixth_section_title !!}<br>
        {!! $sixth_section_subtitle !!}
      </h3>
    </div>
    <div class="row">
      <div class="col-lg-12">
        {!! do_shortcode(App::echo_shortcode($mailchimp_shortcode)) !!}
      </div>
    </div>
  </div>
</section>
