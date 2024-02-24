<div class="mt-8">
    <div class="w-128 mx-auto bg-gray-800 text-white text-sm rounded-lg overflow-hidden">
        <div class="relative">
            <div class="flex items-center justify-between px-4 py-6">
                <div class="flex items-center">
                    <div>
                        <div class="text-5xl font-semibold">{{ round($currentWeather['main']['temp'])}}&#176; C</div>
                        <div class="text-gray-300 font-semibold">Feels like {{ round($currentWeather['main']['feels_like'])}}&#176; C</div>
                    </div>
                    <div class="ml-5">
                        <div class="font-semibold">{{ ucfirst($currentWeather['weather'][0]['description']) }}</div>
                        <div class="text-gray-300">{{ ucfirst($currentWeather['name']) }}, {{ $currentWeather['sys']['country'] }}</div>
                    </div>
                </div>

                <div>
                    <?php 
                        $currentWeatherIcon = $currentWeather['weather'][0]['icon'];
                        //$currentWeatherIcon = '13d';
                    ?>
                    <img src="https://openweathermap.org/img/wn/{{ $currentWeatherIcon }}@2x.png" 
                        alt="current-weather-icon"
                        @class([
                            'current-weather-icon' => $currentWeatherIcon == '13d' || $currentWeatherIcon == '13n'
                        ])
                    >
                    {{-- <img src="https://openweathermap.org/img/wn/13d@2x.png"
                        @class([
                            'current-weather-icon' => $currentWeatherIcon == '13d' || $currentWeatherIcon == '13n'
                        ])> --}}
                </div>
            </div>

            {{-- <button class="absolute right-0 bottom-0 mb-2 mr-2 text-xs">Toggle</button> --}}
        </div> <!-- current-weather -->
        <div class="bg-gradient-to-b from-gray-800 to-indigo-400 px-4 py-6 space-y-8">
            @foreach ($futureWeather as $weather)
                <div class="flex items-center justify-between w-full">
                    <!-- Day/date column -->
                    <div class="flex-col w-3/12 text-white mt-3">
                        @if (\Carbon\Carbon::parse($weather['time'])->isToday())
                            <div>Today</div>
                            <div>{{ \Carbon\Carbon::parse($weather['time'])->format('d M') }}</div>
                        @elseif (\Carbon\Carbon::parse($weather['time'])->isTomorrow())
                            <div>Tomorrow</div>
                            <div>{{ \Carbon\Carbon::parse($weather['time'])->format('d M') }}</div>
                        @else
                            <div>{{ \Carbon\Carbon::parse($weather['time'])->format('D') }}</div>
                            <div>{{ \Carbon\Carbon::parse($weather['time'])->format('d M') }}</div>
                        @endif
                    </div>

                    <!-- Weather icon column -->
                    <div class="flex items-center w-3/12 space-x-2">
                        <?php
                            // find the image file depending on the weatherCode returned by an API
                            $weatherCode = $weather['values']['weatherCodeMax'];
                            $weatherCodeDay = $weatherCode . '0';
                            $weatherCodeNight = $weatherCode . '1';

                            $filePathDay = glob("images/small/*" . $weatherCodeDay . "*");
                            $filePathNight = glob("images/small/*" . $weatherCodeNight . "*");
                            if (count($filePathDay) > 0) {
                                $path = $filePathDay[0];
                            } else if (count($filePathNight) > 0) {
                                $path = $filePathNight[0];
                            }
                        ?>

                        <!-- icon -->
                        <div class="w-8 h-6">
                            {{-- <img src="{{ asset('images/small/' . $weather['values']['weatherCodeMax'] . '.png') }}" > --}}
                            <img src="{{ asset($path) }}" alt="future-weather-icon">
                        </div>

                        <!-- Precipitation probability -->
                        <div class="flex-col mt-3">
                            <div>{{ $weather['values']['precipitationProbabilityMax'] }}%</div>
                            <div>{{ round($weather['values']['rainIntensityMax'], 1) }}mm</div>
                        </div>
                    </div>

                    <!-- Temp(Max/Min) -->
                    <div class="flex items-end justify-end w-6/12 text-white text-right text-xs">
                        <div class="flex items-end justify-end w-full flex-row">
                            <div class="mr-1">
                                <svg class="fill-current" 
                                    width="10" 
                                    height="20"
                                    viewBox="0 0 384 512">
                                    <path d="M214.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 141.2V448c0 17.7 14.3 32 32 32s32-14.3 32-32V141.2L329.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160z"/>
                                </svg> <!-- arrow-up icon -->
                            </div>
                            <div class="">{{ round($weather['values']['temperatureMax']) }}&#176; C</div>
                            
                            <div class="ml-4 mr-1">
                                <svg class="fill-current" 
                                    width="10" 
                                    height="20"
                                    viewBox="0 0 384 512">
                                    <path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/>
                                </svg> <!-- arrow-down icon -->
                            </div>
                            <div class="">{{ round($weather['values']['temperatureMin']) }}&#176; C</div>
                        </div>
                    </div>

                    {{-- <div class="w-3/12 text-right text-xs">
                        <div class="">4&#176; C</div>
                        <div class="">4&#176; C</div>
                    </div> --}}
                </div>
            @endforeach
        </div> <!-- future-weather -->
    </div>
</div>
