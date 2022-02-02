<section class="author">
  @if($author['image'])
    <img class="author__image" src="{{$author['image']}}" />
  @endif
  <div data-control="expandable">
    <p class="author__name"><a href="{!! $author['link'] !!}"> {!! $author['name'] !!} - {!! $author['job'] !!}</a></p>
    <a href="{!! $author['org_link'] !!}" class="author-details__org">{!! $author['organisation'] !!}</a>
    <p class="author__text js-expandable">{!! $author['description'] !!}</p>
    <a role="button" class="author__button open js-expand">
      {!! pll__('See all', 'youmatter') !!}
    </a>
  </div>
</section>
