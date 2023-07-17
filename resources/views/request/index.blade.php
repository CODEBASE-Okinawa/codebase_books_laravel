<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('本リクエスト') }}
            </h2>

            <div>
                <a href="{{ url()->previous() }}">戻る</a>
            </div>
        </div>
  </x-slot>

  <form class="mt-10" action="request/search" method="get">
    @csrf
    <input type="text" name="title" value="" required>
    <button type="submit">検索</button>
  </form>

    <p>検索結果</p>
    

</x-app-layout>
