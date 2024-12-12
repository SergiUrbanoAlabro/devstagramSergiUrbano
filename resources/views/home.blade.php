@extends('layouts.app')

@section('titol')

@endsection

@section('contingut')
    <x-llistar-post :posts="$posts"/>
@endsection