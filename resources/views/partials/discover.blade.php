<section class="discover discover--{{ $layout }}">
  @if($title)
  <h6 class="title title--spacer">{!! pll__('Discover<br> other themes') !!}</h6>
  @endif
  @if($items)
    <nav class="discover__items">
    @foreach($items as $item)
      <a href="{{ $item['url'] }}" class="discover__btn">
        @if($item['image'])
        <img src="{{ $item['image'] }}" alt="" class="discover__image" />
        @endif
        {!! $item['title'] !!}
      </a>
    @endforeach
    </nav>
  @endif
</section>
