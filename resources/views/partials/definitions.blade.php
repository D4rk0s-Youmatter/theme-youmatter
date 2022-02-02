<section class="definition" data-control="definitions">

  <header class="wrapper definition__header">
    @php $k = 0; @endphp
    @foreach ( TemplateDefinitions::getDefinitionsHeader() as $letter)
      @php $k === 0 ? $active = true : $active = false; @endphp
      <a href="#" rel="letter_{!! $letter !!}" class="definition__header__link @php if( $active ){ echo 'definition__header__link--active'; } @endphp">{!! $letter !!}</a>
      @php $k++; @endphp
    @endforeach
  </header>

  <div class="definition__content">
    <div class="wrapper">
      @foreach ( TemplateDefinitions::getDefinitionsContent() as $letter => $definitions)
        <div class="definition__row" id="letter_{!! $letter !!}">
          <span class="definition__letter">{!! $letter !!}</span>
          @foreach ( $definitions as $definition)
            <a href="{!! $definition['link'] !!}" class="definition__link">
              <span>{!! $definition['title'] !!}</span>
            </a>
          @endforeach
        </div>
      @endforeach
      <a href="#" class="definition__go_top btn btn--border"></a>
    </div>
  </div>
</section>