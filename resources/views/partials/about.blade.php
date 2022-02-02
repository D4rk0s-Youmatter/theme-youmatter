<section class="about__intro">
  <div class="wrapper">
    <h1 class="title title--spacer title--bold title--highlight">{!! $intro_title !!}</h1>
    <h2 class="title title--spacer title-light title--medium title--highlight">{!! $intro_subtitle !!}</h2>
    <div>{!! $intro_content !!}</div>
  </div>
</section>

<section class="about__values">
  <div class="wrapper">
    <h2 class="about__values__title title title--white">{!! $values_title !!}</h2>
    <div class="row--grid-three">
      @foreach($values as $value)
        <article>
          <div class="about__values__btn">
            <img src="{!!$value->value_icon!!}" alt="{!!$value->value_title!!}" />
            <h3>{!!$value->value_title!!}</h3>
          </div>
          <div class="about__values__ctn">{!!$value->value_description!!}</div>
        </article>
      @endforeach
    </div>
  </div>
</section>

<section class="about__purpose">
  <div class="wrapper">
    <h2 class="about__purpose__title title title--highlight">{!! $purpose_title !!}</h2>
    <div class="about__purpose__description">{!! $purpose_description !!}</div>
  </div>
</section>

<section class="about__ambition">
  <div class="wrapper">
    <h2 class="about__ambition__title title title--highlight">{!! $ambition_title !!}</h2>
    <h3 class="about__ambition__subtitle title--highlight">{!! $ambition_subtitle !!}</h3>
    <div class="about__ambition__bar" data-control="animatedbar" data-start="{!! $bar_start_value !!}" data-end="{!! $bar_end_value !!}" data-current="{!! $bar_current_value !!}">
      <em></em>
      <i></i>
      <span>{!! $bar_current_value !!}%</span>
    </div>
    <p class="about__ambition__text">{!! $bar_explanation !!}</p>
  </div>
</section>

<section class="about__data">
  <div class="wrapper">
    <h2 class="about__ambition__title title title--highlight">{!! $data_title !!}</h2>
    <div class="about__data__graph">
      {!! $data_html_code !!}
    </div>
    <div class="about__data__graphs">
      <div class="row--grid-three">
        @if(!empty($data_values))
          @foreach($data_values as $data)
            <div class="about__data__graphs__item">
              <h3 class="title title--medium title--highlight">{!! $data->value !!}</h3>
              <div>{!! $data->description !!}</div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
</section>

<section class="about__team" data-control="about">
  <div class="wrapper">
    <h2 class="about__team__title title title--white">{!! $team_title !!}</h2>
    @php $k=0; @endphp
    @if(!empty($team))
      <div class="about__team__members">
        @php $k=0; @endphp
        @foreach($team as $member)
          @if($k < 2)
            <div class="about__team__member  {{$k}}">
              <figure>{!!$member['avatar'] !!}</figure>
              <div>
                <h3>{!!$member['name'] !!}</h3>
                <h4>{!!$member['fonction'] !!}</h4>
                <div>
                  @if($member['linkedin'])
                    <a href="{{$member['linkedin']}}" class="author-details__social" target="_blank">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
                      </svg>
                    </a>
                  @endif
                  @if($member['twitter'])
                    <a href="{{$member['twitter']}}" class="author-details__social" target="_blank">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                      </svg>
                    </a>
                  @endif
                </div>
              </div>
            </div>
            @php $k++; @endphp
          @endif
        @endforeach
      </div>
    @endif
    <div class="row row--center">
      <a href="#" class="btn btn--border-white js-loadmore">Load more</a>
    </div>
    @if(!empty($team))
      <div class="about__team__members about__team__members--extra">
        @php $k=0; @endphp
        @foreach($team as $member)
          @if($k >= 2)
            <div class="about__team__member {{$k}}">
              <figure>{!!$member['avatar'] !!}</figure>
              <div>
                <h3>{!!$member['name'] !!}</h3>
                <h4>{!!$member['fonction'] !!}</h4>
                <div>
                  @if($member['linkedin'])
                    <a href="{{$member['linkedin']}}" class="author-details__social" target="_blank">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path>
                      </svg>
                    </a>
                  @endif
                  @if($member['twitter'])
                    <a href="{{$member['twitter']}}" class="author-details__social" target="_blank">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                      </svg>
                    </a>
                  @endif
                </div>
              </div>
            </div>
          @endif
          @php $k++; @endphp
        @endforeach
      </div>
    @endif
  </div>
</section>

<section class="about__transparency">
  <div class="wrapper">
    <h2 class="about__transparency__title title title--spacer title--highlight">{!! $transparency_title !!}</h2>
      @if (!empty($items))
        @foreach($items as $item)
          <article class="about__transparency__item" data-control="accordion">
            <a href="#" class="title title--medium js-expand">{!!$item->title!!}</a>
            <div class="js-expandable">{!!$item->description!!}</div>
          </article>
        @endforeach
      @endif
  </div>
</section>

<section class="about__contact">
  <div class="wrapper">
    <div class="row row--center row--column">
      <h2 class="about__contact__title title title--spacer title--highlight">{!! $contacts_title !!}</h2>
      <h3 class="about__contact__subtitle title--highlight">{!! $contacts_description !!}</h3>
      <a href="{{ $contacts_link }}?opt={{$contacts_option?$contacts_option:0}}" class="btn btn--blue_dark jobs__contact__button">{{ $contacts_label }}</a>
    </div>
  </div>
</section>