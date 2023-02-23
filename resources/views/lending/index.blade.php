<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('貸出一覧') }}
            </h2>

            <div>
                <a href="{{ url()->previous() }}">戻る</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between">
                    @foreach ( $lendings as $lending )
                        <div class="w-1/5">
                            <a href="{{ route('lending.show', ['lendingId' => $lending->id]) }}">
                                <img class="object-cover w-full" src="{{ asset('storage/'.$lending->book->image_path) }}"
                                     alt="book">
                                <ul class="bg-zinc-400 p-3">
                                    <li class="text-2xl font-bold">{{ $lending->book->title }}</li>
                                    <li>{{ \Carbon\Carbon::parse($lending->end_at)->format('Y年m月d日')}}まで</li>
                                </ul>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

