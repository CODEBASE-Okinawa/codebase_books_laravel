{{--とりあえず形だけ作っている状態。フォームアクションは未完成--}}
<h1>{{ $book->title }}</h1>
<img src="{{ asset('storage/'.$book->image_path) }}" alt="">
<div>
    <form action="{{ route('reservation.store') }}" method="post">
        @csrf
        <input type="hidden" name='book_id' value="{{ $book->id }}">
        <input type="date" name='start_at'>から
        <input type="date" name='end_at'>まで
        <input type="submit" value="借りる">
        <input type="submit" value="予約する">
    </form>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <a href="{{ route('book.index') }}"><input type="submit" value="戻る"></a>
</div>

