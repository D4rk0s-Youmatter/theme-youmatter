<header class="hero">
  <figure class="hero__figure {{ App::showAttachmentImage($bg_id) ? 'hero__cover' : '' }}">
    {!! App::get_attachment_image($bg_id, 'full', array('class' => 'hero__img' )) !!}
  </figure>
  <div class="hero__wrap">
    <div class="hero__content">
      @if(isset($anim) && $anim)
      <h1
        class="hero__title"
        data-control="ticker"
        data-words="{!! pll__('companies') !!},{!! pll__('public organizations') !!},{!! pll__('brands') !!},{!! pll__('NGOs') !!}"
      >
         {!! pll__('We help') !!} <br />
         <span class="hero__anim js-anim"></span><br />
         <span class="hero__subtitle">{!! pll__('of all sizes better address their clients on issues that truly matter to them') !!}</span>
      </h1>
      @else
      <h1 class="hero__title">
        {!! $title !!}
      </h1>
      @endif
    </div>
  </div>
</header>
