<section class="home--recents">
    <div class="wrapper">
        <div class="home--recents_head">
            <h2 class="home--recents_head_title">{!! $recent_posts_title !!}</h2>
            <a href="@php echo get_category_link(1) @endphp" class="home--recents_head-link">{!! $recent_posts_button_text !!} @include('partials.svg.home-arrow')</a>
        </div>
        <div class="articles">
            <div class="swiper-articles swiper-container">
                <div class="swiper-wrapper flex_grid_x4">
                    @php $lastPosts = Frontpage::lastPosts(); @endphp
                    @if ($lastPosts)
                        @foreach ($lastPosts->posts as $post)
                            <div class="swiper-slide">
                                @php if($post->post_type == "post") : @endphp
                                    @include('partials.objects.post-card')
                                @php else : @endphp
                                    @include('partials.objects.post-transition-card')
                                @php endif; @endphp
                            </div>
                        @endforeach
                    @endif
                </div>
                        
        </div>
        <hr class="home--recents_separator">    
</section>
