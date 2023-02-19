<h1>本一覧</h1>
@foreach( $books as $book )
    <div class="book">
        <a href="{{ '/books/'.$book->id }}">
            <ul>
                <li><img src="{{ asset('storage/'.$book->image_path) }}" alt="book"></li>
                <li>{{ $book->title }}</li>
{{--                ステータス可変表示は未完成--}}
                @if($book->lendings()->where('is_returned', 0))
                    <li>貸出中</li>
                @else
                    <li>貸出可能</li>
                @endif
            </ul>
        </a>
    </div>
@endforeach
