<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('本一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between">
                    @foreach( $books as $book )
                        <div class="w-1/5">
                            <a href="{{ route('book.show', ['bookId' => $book->id]) }}">
                                <img class="object-cover w-full" src="{{ asset('storage/'.$book->image_path) }}"
                                     alt="book">
                                <ul class="bg-zinc-400 p-3">
                                    <li class="text-2xl font-bold">{{ $book->title }}</li>
                                    {{--                ステータス可変表示は未完成--}}
                                    <li>{{ $book->lendings->value('is_returned') }}</li>
                                </ul>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
