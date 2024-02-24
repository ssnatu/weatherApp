@extends('layouts.app')

@section('content')
    {{-- <x-weather-widget /> --}}
    <x-weather-widget :currentWeather="$currentWeather" :futureWeather="$futureWeather" />
@endsection
