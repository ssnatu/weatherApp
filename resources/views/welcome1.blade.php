@extends('layouts.app')

@section('content')
    <?php
        dump('hello');
        $weatherCode = '2100';
        $weatherCodeDay = $weatherCode . '0';
        $weatherCodeNight = $weatherCode . '1';

        dump($weatherCodeDay, $weatherCodeNight);
        $fileDay = glob("images/small/*" . $weatherCodeDay . "*");dump($fileDay);
        $fileNight = glob("images/small/*" . $weatherCodeNight . "*");dump($fileNight);
        if (count($fileDay) > 0) {
            $fileName = $fileDay[0];dump($fileName);
        } else if (count($fileNight) > 0) {
            $fileName = $fileNight[0];dump($fileName);
        }
    ?>
@endsection