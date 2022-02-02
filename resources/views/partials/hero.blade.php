<header class="hero {{App::showAttachmentImage($bg_id) ? 'hero--large' : ''}}">
  <figure class="hero__figure {{ App::showAttachmentImage($bg_id) ? 'hero__cover' : '' }}">
    {!! App::get_attachment_image($bg_id, 'full', array('class' => 'hero__img' )) !!}
  </figure>
  @include('partials.breadcrumbs')
  <div class="hero__wrap @if(get_post_type()==='organisations') hero__wrap--column @endif">
    <div class="hero__content">

        @if($filteredcats) 
      
      <div class="hero__meta">{!! $filteredcats !!}</div>
      @endif
      <h1 class="hero__title @if($organisation_logo) hero__title--flex @endif">
        @if($organisation_logo)
          <sub class="hero__logo">
            {!!$organisation_logo!!}
          </sub>
        @endif
        {!! $title !!}
        @if($icon)
        <sup>
          <img src="{!! $icon !!}" class="hero__icon" />
        </sup>
        @endif
      </h1>
      @if($description)
        @if(basename(get_page_template()) === 'template-definitions.blade.php')
          <p class="hero__description hero__description--full">{!! $description !!}</p>
        @else
          <p class="hero__description">{!! $description !!}</p>
        @endif
      @endif
      @if($related_date)
      <p class="hero__description">{{pll_e('Last modified on', 'youmatter') }} {!! $related_date !!}</p>
      @endif
      @if($child_categories)
      <nav class="hero__footer">
        @foreach($child_categories as $child_category)
        <a href="{{ $child_category['url'] }}"
          class="btn btn--border btn--wrap">{!! $child_category['name'] !!}</a>
        @endforeach
      </nav>
      @endif
    </div>
    @if($show_subscription && !App::isProduction())
    <div class="hero__aside">
      <button
        class="btn btn--more"
        @if(App::canInteract())
        {{-- TODO WHAT DOES THIS DO? --}}
        @else
        data-lightbox-open="locked"
        @endif
      >
      @if(get_post_type()==='organisations')
        {{ pll__('Follow this organisation', 'youmatter') }}</button>
        @else
        {{ pll__('Follow this category', 'youmatter') }}</button>
      @endif
      @include('partials.tooltip', [
      'tooltip_content' => pll__('Follow this category and receive all the related news in your inbox each week!', 'youmatter')
      ])
    </div>
    @endif
  </div>
</header>
