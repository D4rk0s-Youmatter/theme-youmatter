<section class="home--hero">
    <div class="wrapper">
        <div class="row home--hero_row">
            <div class="home--hero_txt">
                <h1 class="home--hero_txt_title">{!! $first_section_title !!}</h1>
                <p class="home--hero_txt_subtitle">{!! $first_section_text !!}</p>
                <a href="{!! $first_section_button_link !!}" class="btn btn--fill home--hero_txt_btn"
                    target="_blank">{!! $first_section_button_label !!}</a>
            </div>
            <div class="home--hero_articles articles row">
                <div class="swiper-articles swiper-container">
                    <div class="swiper-wrapper flex_grid_x2">
                        @php $featuredPosts = Frontpage::featuredPosts(); @endphp
                        @if ($featuredPosts)
                            @foreach ($featuredPosts->posts as $post)
                                <div class="swiper-slide">
                                    @include('partials.objects.post-card')
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
