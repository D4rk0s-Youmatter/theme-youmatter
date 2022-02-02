<ul class="comments__list">
@foreach($comments as $comment)
  <li id="comment-{{ $comment['id'] }}">
    <header class="comments__header">
      <cite class="comments__author">{!! $comment['author'] !!}</cite>
      <time class="comments__time">{!! $comment['date'] !!}</time>
    </header>
    <div class="comments__text">{!! $comment['text'] !!}</div>
    @if($comment['can_reply'])
    @endif
    @if ($comment['children'])
      @include('partials.comments-list', ['comments' => $comment['children']])
    @endif
  </li>
@endforeach
</ul>
