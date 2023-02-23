<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('予約一覧') }} > {{ $reservation->book->title }}
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
                    <img class="object-cover w-1/3" src="{{ asset('storage/' . $reservation->book->image_path) }}" alt="">
                    <div class="w-1/2">
                        <p class="text-4xl font-bold mb-4">{{ $reservation->book->title }}</p>
                        <p class="inline-block font-bold bg-yellow-300 px-8">予約しています</p>

                        <form class="mt-10" action="{{ route('reservation.destroy', ['reservationId' => $reservation->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input class="w-full bg-red-600 text-white font-bold py-3" type="submit" value="予約を取り消す">
                        </form>

                        <div class="mt-10">
                            <p class="text-xl">以下の日程で予約しています</p>
                            <p class="font-bold text-2xl">{{ \Carbon\Carbon::parse($reservation->start_at)->toDateString()}}
                                ~ {{ \Carbon\Carbon::parse($reservation->end_at)->toDateString()}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
