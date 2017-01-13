<?php

/*
 * This file is part of the motivatedsloth/noaa package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace noaa;
use noaa\Base;
use DateTime;

/**
 * class to describe a forecast period
 */
class ForecastPeriod extends Base{

		public function __construct($properties){
				$this->properties = $properties;
		}

		/**
		 * @return int numerical position of period
		 */
		public function getNumber(){
				return $this->properties->number;
		}

		/**
		 * @return string name of period, empty string for hourly, Today, Sunday Monday etc for day forecast
		 */
		public function getName(){
				return $this->properties->name;
		}

		/**
		 * @param string $format for date function
		 * @return DateTime|string start time of period in local time zone
		 */
		public function getStart($format = null){
				$dt = new DateTime($this->properties->startTime);
				if($format){
						return date($format, $dt->getTimestamp());
				}
				return $dt;
		}

		/**
		 * @param string $format for date function
		 * @return DateTime|string end time of period in local time zone
		 */
		public function getEnd($format = null){
				$dt = new DateTime($this->properties->endTime);
				if($format){
						return date($format, $dt->getTimestamp());
				}
				return $dt;
		}

		/**
		 * @return bool true if between 6am and 6pm
		 */
		public function getIsDayTime(){
				return $this->properties->isDayTime == true;
		}

		/**
		 *
		 * @param string optional units F or C default is F
		 * @return float temperature expected for this period in degrees F
		 */
		public function getTemperature($unit = "F"){
				if($unit == "F"){
						return $this->properties->temperature;
				}else{
						return ($this->properties->temperature - 32) * 0.5556;
				}
		}

		/**
		 * @return string wind speed ie 15 mph
		 */
		public function getWindSpeed(){
				return $this->properties->windSpeed;
		}

		/**
		 * @return string wind direction ie WNW
		 */
		public function getWindDirection(){
				return $this->properties->windDirection;
		}

		/**
		 * @return string url of icon 
		 */
		public function getIcon(){
				return $this->properties->icon;
		}

		/**
		 * @return string short forecast summary
		 */
		public function getShortForecast(){
				return $this->properties->shortForecast;
		}

		/**
		 * @return string detailed forecast
		 */
		public function getDetailedForecast(){
				return $this->properties->detailedForecast;
		}
}//class
