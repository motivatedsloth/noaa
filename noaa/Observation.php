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
		 * @return \DateTime observation was recorded
		 */
		public function getTime(){
				return new \DateTime($this->properties->properties->timestamp);
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
				return $this->properties->properties->temperature;
		}

		/**
		 * @return float dewpoint in degrees C
		 */
		public function getDewpoint(){
				return $this->properties->properties->dewpoint;
		}

		/**
		 * @return int wind direction in degrees
		 */
		public function getWindDirection(){
				return $this->properties->properties->windDirection;
		}

		/**
		 * @return float wind speed in m/s
		 */
		public function getWindSpeed(){
				return $this->properties->properties->windSpeed;
		}

		/**
		 * @return float wind gusts in m/s
		 */
		public function windGust(){
				return $this->properties->properties->windGust;
		}

		/**
		 * @return int barometric pressure in Pa
		 */
		public function getBarometricPressure(){
				return $this->properties->properties->barometricPressure;
		}

		/**
		 * @return int visibility in meters
		 */
		public function getVisibility(){
				return $this->properties->properties->visibility;
		}

		/**
		 * @return float last hours precip in meters
		 */
		public function getPrecipitationLastHour(){
				return $this->properties->properties->precipitationLastHour;
		}

		/**
		 * @return float relative humidity in percent
		 */
		public function getRelativeHumidity(){
				return $this->properties->properties->relativeHumidity;
		}

		/**
		 * @return float wind chill in degrees C
		 */
		public function getWindChill(){
				return $this->properties->properties->windChill;
		}

		/**
		 * @return float heat index in degrees C
		 */
		public function getHeatIndex(){
				return $this->properties->properties->heatIndex;
		}
}


