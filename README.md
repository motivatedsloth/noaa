# noaa
A php library for working with the NOAA api
The [NOAA documentation](https://forecast-v3.weather.gov/documentation)

Forecasts can be retrieved for a point or a station.
Both the hourly and daily forecast return 7 days worth of data.

Basic Usage for Forecast for a given point
==========================================

    <?php
	include "noaa/autoload.php"; //only needed if not using composer bootstrap
    use noaa\util\Cache;
    use noaa\Point;
    use noaa\NOAA;

    $noaa = new NOAA(new Cache);
    $point = new Point(43.43, -90.80);
    $noaa->setPoint($point);
    $hourly = $noaa->getHourlyForecast();
    foreach($hourly as $forecast){
        echo $forecast->getStart('D, d M H:i:s') . " Temp:" . $forecast->getTemperature() . "\n";
    }
