
<a href="{{ route('lending.show', ['lendingId' => $lending->id]) }}">
  <img src="{{ asset('storage/', $lending->book->image_path) }}" alt="">

  <h3>{{ $lending->book->title }}</h3>
  
</a>

<form action="{{ route('lending.updateIsReturned', ['lendingId' => $lending->id]) }}" method="post">
  @csrf
  @method('PUT')
  <input type="submit" value="返却する">
</form>

@if ($lending->end_at < $now)

  <p>	返却期間過ぎています！</p>

@else()

  <p>{{ \Carbon\Carbon::parse($lending->end_at)->format('Y年m月d日 H:i')}}まで借りています</p>

@endif