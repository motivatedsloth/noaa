<?php
/**
 * Class to describe a point
 */
namespace noaa;
use noaa\Base;

/**
 * Point class is constructed with latitude and longitude
 */
class Point extends Base{
		/**
		 * Refresh Frequency
		 * @see http://php.net/manual/en/dateinterval.construct.php
		 */
		const TTL = "P1D";

		/**
		 * @var float latitude
		 */
		private $lat;
		/**
		 * @var float longitude
		 */
		private $lon;

		/**
		 * @param $lat float latitude
		 * @param $lon float longitude
		 */
		public function __construct($lat, $lon){
				$this->lat = $lat;
				$this->lon = $lon;
		}

		/**
		 * @return float latitude for this point
		 */
		public function getLat(){
				return (float) $this->lat;
		}

		/**
		 * @return float longitude for this point
		 */
		public function getLon(){
				return (float) $this->lon;
		}

		/**
		 * @return string city for this point
		 */
		public function getCity(){
				return $this->properties->properties->relativeLocation->properties->city;
		}
		
		/**
		 * @return string state
		 */
		public function getState(){
				return $this->properties->properties->relativeLocation->properties->state;
		}
		
		/**
		 * @return string timezone
		 */
		public function getTimeZone(){
				return $this->properties->properties->timeZone;
		}

		/**
		 * @return string forecast id
		 */
		public function getForecast(){
				return $this->properties->properties->forecast;
		}

		/**
		 * @return string forecastHourly id
		 */
		public function getForecastHourly(){
				return $this->properties->properties->forecastHourly;
		}

		/**
		 * @return string observationStations
		 */
		public function getObservationStations(){
				return $this->properties->properties->observationStations;
		}
}
