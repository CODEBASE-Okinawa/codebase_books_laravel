<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('isbn検索画面') }}
            </h2>
            <div>
                <a href="{{ url()->previous() }}">戻る</a>
            </div>
        </div>
    </x-slot>

    <form class="mt-10" action="/search" method="get">
        @csrf
        <input type="text" name="isbn_10" value="" required>
        <button type="submit">検索</button>
    </form>

    @if(isset($book))
        <p>タイトル：{{ $book['title'] }}</p>
        <p>ISBN-10: {{ $book['isbn_10'] }}</p>
        <img src="{{ $book['image'] }}" alt="book image">

        @if($book['is_exist'])
            <p>購入済み</p>
        @else
            <form action="/create" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="title" value="{{ $book['title'] }}" required>
                <input type="hidden" name="isbn_10" value="{{ $book['isbn_10'] }}" required>
                <input type="hidden" name="image_path" value="{{ $book['image'] }}">

                <button type="submit">登録</button>
            </form>
        @endif
    @endif
</x-app-layout>
