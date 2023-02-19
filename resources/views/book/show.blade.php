{{--とりあえず形だけ作っている状態。フォームアクションは未完成--}}
<h1>{{ $book->title }}</h1>
<img src="{{ asset('storage/'.$book->image_path) }}" alt="">
<div>
    <form action="">
        <input type="date">から
        <input type="date">まで
        <input type="submit" value="借りる">
        <input type="submit" value="予約する">
    </form>
</div>

<div>
    <a href="/books"><input type="submit" value="戻る"></a>
</div>

