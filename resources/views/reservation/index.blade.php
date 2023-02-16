<h1>予約している本一覧</h1>

@foreach ( $reservations as $reservation)

  <a href="">
    <img src="{{ asset($reservation->book->image_path) }}" alt="">

    <h3>{{ $reservation->book->title }}</h3>
    <h3>{{ \Carbon\Carbon::parse($reservation->start_at)->format('Y年m月d日')}}から</h3>
  </a>
  
@endforeach