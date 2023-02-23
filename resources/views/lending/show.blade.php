<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('貸出一覧') }} > {{ $lending->book->title }}
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
                    <img class="object-cover w-1/3" src="{{ asset('storage/'.$lending->book->image_path) }}" alt="">
                    <div class="w-1/2">
                        <p class="text-4xl font-bold mb-4">{{ $lending->book->title }}</p>
                        <p class="inline-block font-bold bg-sky-500 px-8">現在借りています</p>

                        <form class="mt-10" action="{{ route('lending.updateIsReturned', ['lendingId' => $lending->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <input class="w-full bg-red-600 text-white font-bold py-3" type="submit" value="返却する">
                        </form>

                        <div class="mt-10">
                            @if ($lending->end_at < $now)
                                <p class="font-bold text-4xl">返却日が過ぎています！</p>
                                <p class="font-bold text-3xl mt-8">早く返却しないとジュリさんが追いかけてくるので注意してください！！</p>
                            @else
                                <p class="font-bold">{{ \Carbon\Carbon::parse($lending->end_at)->format('Y年m月d日 H:i')}}まで借りています</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
