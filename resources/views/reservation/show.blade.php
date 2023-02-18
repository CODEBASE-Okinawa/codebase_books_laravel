<a href="">
  <img src="{{ asset($reservation->book->image_path) }}" alt="">

  <h3>{{ $reservation->book->title }}</h3>
  <h3>{{ \Carbon\Carbon::parse($reservation->start_at)->toDateString()}} ~ {{ \Carbon\Carbon::parse($reservation->end_at)->toDateString()}}</h3>
</a>

<form action="{{ route('reservation.destroy', ['reservationId' => $reservation->id]) }}" method="post">
  @csrf
  @method('DELETE')
  <input type="submit" value="予約を取り消す">
</form>