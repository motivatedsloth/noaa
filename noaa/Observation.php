<?php

/*
 * This file is part of the noaa package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace noaa;
use noaa\Base;
use noaa\Station;

/**
 * Observation data
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Observation extends Base{

		public function __construct($props = null){
				if($props){
						$this->setProperties($props);
				}
		}
		/**
		 * @string id for this observation
		 */
		public function getId(){
				return $this->properties->id;
		}

		/**
		 * @return string id of station
		 */
		public function getStationId(){
				return $this->properties->properties->station;
		}

		/**
		 * @param string optional format string
		 * @return \DateTime|string observation was recorded
		 */
		public function getTime($format = null){
				$dt = new \DateTime($this->properties->properties->timestamp);
				if($format){
						return date($format, $dt->getTimestamp());
				}
				return $dt;
		}

		/**
		 * @return string description
		 */
		public function getDescription(){
				return $this->properties->properties->description;
		}

		/**
		 * @return float temperature in degrees C
		 */
		public function getTemperature(){
				return $this->properties->properties->temperature->value;
		}

		/**
		 * @return float dewpoint in degrees C
		 */
		public function getDewpoint(){
				return $this->properties->properties->dewpoint->value;
		}

		/**
		 * @return int wind direction in degrees
		 */
		public function getWindDirection(){
				return $this->properties->properties->windDirection->value;
		}

		/**
		 * @return float wind speed in m/s
		 */
		public function getWindSpeed(){
				return $this->properties->properties->windSpeed->value;
		}

		/**
		 * @return float wind gusts in m/s
		 */
		public function windGust(){
				return $this->properties->properties->windGust->value;
		}

		/**
		 * @return int barometric pressure in Pa
		 */
		public function getBarometricPressure(){
				return $this->properties->properties->barometricPressure->value;
		}

		/**
		 * @return int visibility in meters
		 */
		public function getVisibility(){
				return $this->properties->properties->visibility->value;
		}

		/**
		 * @return float last hours precip in meters
		 */
		public function getPrecipitationLastHour(){
				return $this->properties->properties->precipitationLastHour->value;
		}

		/**
		 * @return float relative humidity in percent
		 */
		public function getRelativeHumidity(){
				return $this->properties->properties->relativeHumidity->value;
		}

		/**
		 * @return float wind chill in degrees C
		 */
		public function getWindChill(){
				return $this->properties->properties->windChill->value;
		}

		/**
		 * @return float heat index in degrees C
		 */
		public function getHeatIndex(){
				return $this->properties->properties->heatIndex->value;
		}
}

