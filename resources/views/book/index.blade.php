<ul>
    <li><a href="{{ route('book.index') }}">本一覧</a></li>
    <li><a href="{{ route('lending.index') }}">借りている本一覧</a></li>
    <li><a href="{{ route('reservation.index') }}">予約している本一覧</a></li>
</ul>

<h1>本一覧</h1>
@foreach( $books as $book )
    <div class="book">
        <a href="{{ route('book.show', ['bookId' => $book->id]) }}">
            <ul>
                <li><img src="{{ asset('storage/'.$book->image_path) }}" alt="book"></li>
                <li>{{ $book->title }}</li>
{{--                ステータス可変表示は未完成--}}
                <li>{{ $book->lendings->value('is_returned') }}</li>
            </ul>
        </a>
    </div>
@endforeach
