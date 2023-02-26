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
                    <img class="object-cover w-1/3" src="{{ asset('storage/'.$book->image_path) }}" alt="">
                    <div>
                        <p class="text-4xl font-bold mb-4">{{ $book->title }}</p>
                        <p class="inline-block font-bold bg-lime-500 px-8 {{ config('status.bg-color')[$status] }}">{{ $status }}</p>
                        @if ($status == OTHER_LENDING )
                            <p>{{ \Carbon\Carbon::parse($lending->latestLending->end_at)->addDay()->format('Y年m月d日')}}から貸出・予約可能です</p>
                        @endif
                        
                        <form class="mt-10" id="two-destinations-form" method="POST">
                            @csrf
                            <input type="date" name="start_at" class="w-4/5 mr-2 mb-3" value="{{ old('start_at') }}"><span class="text-2xl">から</span>
                            <input type="date" name="end_at" class="w-4/5 mr-2" value="{{ old('end_at') }}"><span class="text-2xl">まで</span>

                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            <input type="hidden" name="is_returned" value="0">

                            <div class="w-4/5 flex justify-between mt-10">
                                <input type="submit" formaction="{{ route('lending.store') }}" class="w-1/3 {{ $status == OTHER_LENDING ? 'bg-slate-400' : 'bg-sky-500' }} font-bold py-2" {{ $status == OTHER_LENDING ? 'disabled' : '' }} value="借りる">
                                <input type="submit" formaction="{{ route('reservation.store') }}" class="w-1/3 bg-yellow-300 font-bold py-2" value="予約する">
                            </div>
                        </form>
                        
                        @if ($reservationList->count() > 0)
                            <p>下記の日程で予約が入っています。</p>
                            <p>日程が被らないように貸出・予約しましょう。</p>
                            @foreach ( $reservationList as $reservation)
                                <p class="font-bold">・{{ \Carbon\Carbon::parse($reservation->start_at)->format('Y年m月d日')}} ~ {{ \Carbon\Carbon::parse($reservation->end_at)->format('Y年m月d日')}}</p>          
                            @endforeach
                        @endif
                        
                        @if ($errors->any())
                            <div class="alert alert-danger mt-10">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="font-bold text-red-600">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
