@php 
    $time = App::getTimeAgo($post->time);
    $sponsored_message = get_field("sponsored_message", "option");
    $sponsored_text = pll__("Transition program", "youmatter");
@endphp
<div class="articles__card article__sponsored">
    <div class="cat_pill">
        <a href="{{ $post->permalink }}" target="_blank">{{ $sponsored_text }}</a>
        <div class="sponsored_message">{!! $sponsored_message !!}</div>
    </div>

    <a href="{{ $post->permalink }}" class="articles__card_link">
        <figure style="background-image: url({{ $post->thumbnail_url }})" class="articles__image"></figure>
    </a>
        <h3 class="articles__card_title"><a href="{{ $post->permalink }}">{{ $post->title }}</a></h3>
        <p class="articles__card_author">Par <a href="{{ $post->author_link }}">{{ $post->author }}</a></p>
        <hr class="articles__card_separator">
        <p class="articles__card_metadata">{!! App::getReadingTime($post->post_content) !!} {!! pll__('minutes', 'youmatter') !!} • {{ $time }}</p>
</div>