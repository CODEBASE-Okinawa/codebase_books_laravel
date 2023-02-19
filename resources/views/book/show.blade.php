{{--とりあえず形だけ作っている状態。フォームアクションは未完成--}}
<h1>{{ $book->title }}</h1>
<img src="{{ asset('storage/'.$book->image_path) }}" alt="">
<div>
    <form action="{{ route('lending.store') }}" method="post">
        @csrf
        <input type="date" name="start_at">から
        <input type="date" name="end_at">まで
        <input type="hidden" name="book_id" value="{{ $book->id }}">
        <input type="hidden" name="is_returned" value="0">
        <input type="submit" value="借りる">
        <input type="submit" value="予約する">
    </form>
</div>

<div>
    <a href="{{ route('book.index') }}"><input type="submit" value="戻る"></a>
</div>

