<section class="home--read">
    <div class="wrapper">
        <div class="home--read_head">
            <h2 class="home--read_head_title">{!! $popular_posts_title !!}</h2>
            <a href="@php echo get_category_link(1) @endphp/?orderby=views" class="home--read_head-link">{!! $popular_posts_button_text !!} @include('partials.svg.home-arrow')</a>
        </div>


        <div class="articles">
            <div class="swiper-articles swiper-container">
                <div class="swiper-wrapper flex_grid_x4">
                    @php $mostReadPosts = Frontpage::mostReadPosts(); @endphp
                    @if ($mostReadPosts)
                        @foreach ($mostReadPosts as $post)
                            <div class="swiper-slide">
                                @if($post->post_type === "post")
                                    @include('partials.objects.post-card')
                                @else
                                    @include('partials.objects.post-transition-card')
                                @endif;
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>