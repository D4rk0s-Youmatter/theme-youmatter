@if (App::headerMessages())
    <div class="messages">
        @foreach (App::headerMessages() as $key => $message)
            @if($loop->first)
                <div class="message active">{!! $message !!}</div>
            @else
                <div class="message">{!! $message !!}</div>
            @endif
            
        @endforeach
    </div>
@endif
