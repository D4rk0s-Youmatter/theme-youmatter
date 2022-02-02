<nav class="breadcrumbs">
  @if(App::breadcrumbsList())

    @php if(is_array(App::breadcrumbsList())) : @endphp
        @foreach(App::breadcrumbsList() as $breadcrumb)
        <a href="{{ $breadcrumb['url'] }}" class="breadcrumbs__item">
            {!! $breadcrumb['title'] !!}
        </a>
        @endforeach

    @php else : @endphp
      {!! App::breadcrumbsList() !!}
    @php endif; @endphp

  @endif
</nav>
