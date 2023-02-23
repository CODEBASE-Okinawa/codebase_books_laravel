<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('予約している本一覧') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg flex justify-around">
                @foreach ( $reservations as $reservation)
                    <div class="text-gray-900 w-1/5 bg-zinc-400">
                        <a href="{{ route('reservation.show', ['reservationId' => $reservation->id]) }}">
                            <img class="object-cover w-full" src="{{ asset('storage/' . $reservation->book->image_path) }}" alt="">
                            <div class="p-3">
                                <p class="text-2xl font-bold">{{ $reservation->book->title }}</p>
                                <p>{{ \Carbon\Carbon::parse($reservation->start_at)->format('Y年m月d日')}}から</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-app-layout>
