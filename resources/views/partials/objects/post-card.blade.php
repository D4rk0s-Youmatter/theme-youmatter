@php 
    $permalink = get_the_permalink($post->ID);
    $thumbnailUrl = get_the_post_thumbnail_url($post->ID, "post-thumbnail");
    $author = get_the_author_meta("display_name", $post->post_author);
    $time = App::getTimeAgo(get_the_time("U", $post->ID));
    $cat = App::getCardCategory($post->ID);
    $catName = $cat["cat_name"];
    $catLink = $cat["cat_permalink"];
@endphp
<div class="articles__card article__regular">
    <a href="{{ $catLink }}" class="cat_pill">{{ $catName }}</a>
    <a href="{{ $permalink }}" class="articles__card_link">
        <figure style="background-image: url({{ $thumbnailUrl }})" class="articles__image"></figure>
        <h3 class="articles__card_title">{{ $post->post_title }}</h3>
        <p class="articles__card_author">Par {{ $author }}</p>
        <hr class="articles__card_separator">
        <p class="articles__card_metadata">
            {!! App::getReadingTime($post->post_content) !!} {!! pll__('minutes', 'youmatter') !!} • {{ $time }}</p>
    </a>
</div>