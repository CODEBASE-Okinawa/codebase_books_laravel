<h1>借りている本一覧</h1>

@foreach ( $lendings as $lending )

    <a href="{{ route('lending.show', ['lendingId' => $lending->id]) }}">
        <img src="{{ asset('storage/'.$lending->book->image_path) }}" alt="">

        <h3>{{ $lending->book->title }}</h3>
        <h3>{{ \Carbon\Carbon::parse($lending->end_at)->format('Y年m月d日')}}まで</h3>
    </a>

@endforeach

<div>
    <a href="{{ route('book.index') }}"><input type="submit" value="戻る"></a>
</div>
