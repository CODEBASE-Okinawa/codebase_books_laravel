<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('本一覧') }} > {{ $book->title }}
            </h2>

            <div>
                <a href="{{ url()->previous() }}">戻る</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between">
                    <img src="{{ asset('storage/'.$book->image_path) }}" alt="">
                    <div>
                        <p class="text-4xl font-bold mb-4">{{ $book->title }}</p>
                        <p class="inline-block font-bold bg-lime-500 px-8">貸出可能</p>

                        <form class="mt-10" id="two-destinations-form">
                            @csrf
                            <input type="date" name="start_at" class="w-4/5 mr-2 mb-3"><span class="text-2xl">から</span>
                            <input type="date" name="end_at" class="w-4/5 mr-2"><span class="text-2xl">まで</span>

                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <input type="hidden" name="is_returned" value="0">

                            <div class="w-4/5 flex justify-between mt-10">
                                <button type="submit" name="lending" class="w-1/3 bg-sky-500 font-bold py-2">借りる</button>
                                <button type="submit" name="reservation" class="w-1/3 bg-yellow-300 font-bold py-2">予約する</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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
