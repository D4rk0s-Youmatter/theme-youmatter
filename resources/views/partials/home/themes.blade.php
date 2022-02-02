<section class="home--themes">
    <div class="wrapper">
        <h2 class="home--themes-title">{!! Frontpage::themesTitle() !!}</h2>
        <ul class="home--themes-list row">
            @if(!empty(Frontpage::themesList()))
                @foreach (Frontpage::themesList() as $theme)
                    <li class="home--themes-list-item">
                        <a 
                            href="{{ $theme['theme_link'] }}" 
                            class="home--themes-list-item-btn" 
                            style="background-color:{{ $theme['theme_color'] }}"
                        >
                            {{ $theme['theme_title'] }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</section>