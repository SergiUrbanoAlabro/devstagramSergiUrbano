@extends('layouts.app')

@section('titol')
    Crea una nova publicació
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@section('contingut')
    <div class="md:flex md:items-center">
        <div class="md:w-1/2 px-10">
            <form id="dropzone" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center" action="{{ route('imatges.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            </form>
        </div>
        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="mb-2 block uppercase text-gray-500 font-bold" for="titol">
                        Titol publicació
                    </label>
                    <input
                        id="titol"
                        name="titol"
                        type="text"
                        placeholder="El titol de la teva publicació"
                        class="border p-3 w-full rounded-lg @error('titol') border-red-500 @enderror"
                        value="{{ old('titol') }}" />
                    @error('titol')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label class="mb-2 block uppercase text-gray-500 font-bold" for="descripcio">
                        Descripció
                    </label>
                    <textarea
                        id="descripcio"
                        name="descripcio"
                        type="text"
                        placeholder="Descripció de la publicació"
                        class="border p-3 w-full rounded-lg @error('descripcio') border-red-500 @enderror">{{ old('descripcio') }}</textarea>
                    @error('descripcio')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <input
                        name="img"
                        type="hidden"
                        value="{{ old('img') }}" />

                    @error('img')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }}</p>
                    @enderror
                </div>

                <input
                    type="submit"
                    value="Crear publicació"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
            </form>
        </div>
    </div>
@endsection