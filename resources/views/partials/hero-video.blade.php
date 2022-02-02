<header class="hero hero__169"  data-control="hero">
  <figure class="hero__figure {{ App::showAttachmentImage($bg_id) ? 'hero__cover_video' : '' }}">
    {!! App::get_attachment_image($bg_id, 'full', array('class' => 'hero__img' )) !!}
  </figure>
  @if ($video_id)
    <a href="#" class="btn btn--play"></a>
  @endif
  <h2 class="hero__video-title title title--white">{!!$cover_title!!}</h2>
  @if ($video_id)
    <iframe class="hero__video" src="https://www.youtube.com/embed/{{$video_id}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
  @endif
</header>
