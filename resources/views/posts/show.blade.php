@extends('layouts.app')

@section('titol')
{{$post->titol}}
@endsection

@section('contingut')
<div class="container mx-auto md:flex">
    <div class="md:w-1/2">
        <img src="{{ asset('uploads').'/'.$post->img }}" alt="Imatge del post {{$post->titol}}">

        <div class="p-3 flex items-center gap-4">
            @auth
            <livewire:like-post :post="$post" />
            @endauth
        </div>

        <div>
            <p class="font-bold">{{ $post->user->username }}</p>
            <p class="text-sm text-gray-500">
                {{ $post->created_at->diffForHumans() }}
            </p>
            <p class="mt-5">
                {{ $post->descripcio }}
            </p>
        </div>

        @auth
        @if ($post->user_id === auth()->user()->id)
        <form method="POST" action="{{ route('posts.destroy', $post)}}">
            @method('DELETE')
            @csrf
            <input type="submit" value="Eliminar publicació"
                class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
        </form>
        @endif
        @endauth
    </div>
    <div class="md:w-1/2 p-5">
        <div class="shadow bg-white p-5 mb-5">
            @auth
            <p class="text-xl font-bold text-center mb-4">Afegeix un nou comentari</p>

            @if (session('missatge'))
            <div class="bg-green-500 p-2 rounded-lg mb-6 text-white text-center uppercase font-bold">
                {{session('missatge')}}
            </div>
            @endif

            <form action="{{ route('comentaris.store', ['post' => $post, 'user' => $user ]) }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="mb-2 block uppercase text-gray-500 font-bold" for="comentari">
                        Afegeix un comentari
                    </label>
                    <textarea id="comentari" name="comentari" type="text" placeholder="Afegeix un comentari"
                        class="border p-3 w-full rounded-lg @error('comentari') border-red-500 @enderror"></textarea>
                    @error('comentari')
                    <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <input type="submit" value="Comentar"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
            </form>
            @endauth

            <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-10">
                @if ($post->comentaris->count())
                @foreach ($post->comentaris as $comentari)
                <div class="p-5 border-gray-300 border-b">
                    <a href="{{ route('posts.index', $comentari->user) }}" class="font-bold">
                        {{ $comentari->user->username }}
                    </a>
                    <p>{{ $comentari->comentari }}</p>
                    <p class="text-sm text-gray-500">{{ $comentari->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
                @else
                <p class="p-10 text-center">Encara no hi han comentaris</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection