<h1>{{ $lending->book->title }}</h1>

<img src="{{ asset('storage/'.$lending->book->image_path) }}" alt="">
<div>
    <form action="{{ route('lending.destroy', ['lendingId' => $lending->id]) }}" method="post">
        @csrf
        @method('DELETE')
{{--        <input type="hidden" name="book_id" value="{{ $lending->book->id }}">--}}
        <input type="hidden" name="is_returned" value="1">
        <input type="submit" value="返却する">
    </form>
</div>


