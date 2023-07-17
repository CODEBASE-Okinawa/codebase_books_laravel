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

  @if(isset($requestBooksList))
  
    <p>リクエスト可能な本</p>
    <div class="py-12">            
      <form action="/request/create" method="post" enctype="multipart/form-data">
      <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 flex justify-between">
              @csrf
              @foreach( $requestBooksList as $requestBook )
                <div class="w-1/5">
                  <img class="object-cover w-full" src="{{ $requestBook['image_path'] }}" alt="book">
                  <ul class="bg-zinc-400 p-3">
                    <li class="text-2xl font-bold">{{ $requestBook['title'] }}</li>
                    <li class="text-2xl font-bold">{{ $requestBook['isbn_10'] }}</li>
                    <button type="submit" style="color: red;">購入リクエスト</button>
                  </ul>
                  <input type="hidden" name="title" value="{{ $requestBook['title'] }}">
                  <input type="hidden" name="isbn_10" value="{{ $requestBook['isbn_10'] }}">
                  <input type="hidden" name="image_path" value="{{ $requestBook['image_path'] }}">
                </div>
              @endforeach
          </div>
        </div>
      </div>
      </form>

    </div>

  @endif

  @if(isset($books))
    <p>現在ある本</p>
    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 flex justify-between">
                @foreach( $books as $book )
                    <div class="w-1/5">
                      @if("api" == substr(asset('storage/'.$book->image_path), -3))
                          <img class="object-cover w-full" src="{{ $book->image_path }}" alt="book">
                      @endif
                      @if("jpg" == substr(asset('storage/'.$book->image_path), -3))
                          <img class="object-cover w-full" src="{{ asset('storage/'.$book->image_path) }}" alt="book">
                      @endif
                      <ul class="bg-zinc-400 p-3">
                          <li class="text-2xl font-bold">{{ $book->title }}</li>
                      </ul>
                    </div>
                @endforeach
              </div>
            </div>
        </div>
    </div>
  @endif

</x-app-layout>
