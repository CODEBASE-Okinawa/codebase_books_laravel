<h1>{{ $book->title }}</h1>
<img src="{{ asset('storage/'.$book->image_path) }}" alt="">
<div>
    <form id="two-destinations-form">
        @csrf
        <input type="date" name="start_at">から
        <input type="date" name="end_at">まで
        <input type="hidden" name="book_id" value="{{ $book->id }}">
        <input type="hidden" name="is_returned" value="0">
        <button type="submit" name="lending">借りる</button>
        <button type="submit" name="reservation">予約する</button>
    </form>
</div>

<div>
    <a href="{{ url()->previous() }}">戻る</a>
</div>

<script>
    const form = document.querySelector('#two-destinations-form');

    form.addEventListener('submit', (event) => {
        // フォームが正常に送信されないようにする
        event.preventDefault();

        // どのボタンがクリックされたかを判断する
        const lendingButton = form.querySelector('button[name="lending"]');
        const reservationButton = form.querySelector('button[name="reservation"]');
        const clickedButton = event.submitter;

        // フォームデータオブジェクトの生成
        const formData = new FormData(form);

        // どのボタンがクリックされたかに応じて、適切なURLへPOSTリクエストを行う
        if (clickedButton === lendingButton) {
            fetch("{{ route('lending.store') }}", {
                method: 'POST',
                body: formData
            })
                .then(() => {
                    window.location.href = "{{ route('lending.index') }}";
                });
        } else if (clickedButton === reservationButton) {
            fetch("{{ route('reservation.store') }}", {
                method: 'POST',
                body: formData
            })
                .then(() => {
                    window.location.href = "{{ route('reservation.index') }}"
                });
        }
    });
</script>
