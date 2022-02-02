<section class="team">
  <h2 class="team__title">{!! $title !!}</h2>
  <div class="team__description">{!! $description !!}</div>
  @if($people)
  <ul>
    @foreach($people as $person)
      <li class="team__item">
        <img src="{{ $person['image'] }}" class="team__avatar" />
        <span class="team__name">{!! $person['name'] !!}</span>
        {!! $person['description'] !!}
      </li>
    @endforeach
  </ul>
  @endif
</section>
