<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('予約している本一覧') }}
        </h2>
    </x-slot>

    <a href="{{ url()->previous() }}">戻る</a>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg flex justify-around">
                <div class="text-gray-900 w-1/5 bg-zinc-400">

                    <img src="{{ asset('storage/' . $reservation->book->image_path) }}" alt="">

                    <h3>{{ $reservation->book->title }}</h3>
                    <h3>{{ \Carbon\Carbon::parse($reservation->start_at)->toDateString()}}
                        ~ {{ \Carbon\Carbon::parse($reservation->end_at)->toDateString()}}</h3>

                    <form action="{{ route('reservation.destroy', ['reservationId' => $reservation->id]) }}"
                          method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="予約を取り消す">
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
