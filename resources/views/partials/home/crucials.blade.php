<section class="home--crucials">
    <div class="wrapper home--crucials-wrap row">
        <span class="home--crucials-main">
            <h2 class="home--crucials-main-title">{!! $fundamentals_title !!}</h2>
            <a href="{!! $fundamentals_button_link !!}" class="home--crucials-main-link">{!! $fundamentals_button_text !!} @include('partials.svg.home-arrow')</a> 
        </span>
        <ul class="home--crucials-list row">
            @if(!empty(Frontpage::fundamentalsList()))
                @foreach (Frontpage::fundamentalsList() as $fundamental)
                    <li class="home--crucials-list-item">
                        <a 
                            href="{{ $fundamental['fundamental_link'] }}" 
                            class="home--crucials-list-item-btn btn btn--fill" 
                        >
                            {{ $fundamental['fundamental_title'] }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</section>