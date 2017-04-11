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
/**
 * main class for working with noaa forecasts and conditions
 */

use noaa\util\Fetch;
use noaa\util\Cache;
use noaa\Point;
use noaa\Forecast;
use noaa\Station;

class NOAA{
		const POINT = "https://api.weather.gov/points/{point}";
		const STATION = "https://api.weather.gov/stations/{station}";

		/**
		 * @var noaa\Fetch
		 */
		protected $fetch;
		/**
		 * @var noaa\Point
		 */
		protected $point;
		/**
		 * @var noaa\Forecast
		 */
		protected $hourly;
		/**
		 * @var noaa\Forecast
		 */
		protected $daily;
		/**
		 * @var noaa\Station
		 */
		protected $station;
		/**
		 * @var noaa\Observations
		 */
		protected $observations;

		/**
		 * @param noaa\Cache
		 */
		public function __construct(Cache $cache, $apikey = "my_noaa_app"){
				$this->fetch = new Fetch($cache, $apikey);
		}

		/**
		 * @param noaa\Point
		 */
		public function setPoint(Point $point){
				$this->point = $point;
		}

		/**
		 * @return noaa\Point
		 */
		public function getPoint(){
				return $this->point;
		}

		/**
		 * @param noaa\Station
		 */
		public function setStation(Station $station){
				$this->station = $station;
		}

		/**
		 * @return noaa\Station
		 */
		public function getStation(){
				return $this->station();
		}
		
		/**
		 * @return noaa\util\Cache
		 */
		public function getCache(){
				return $this->fetch->getCache();
		}

		/**
		 * ensure point has data loaded
		 */
		protected function point(){
				if(!$this->point->isLoaded()){
						$url = str_replace("{point}", $this->point->getLat() . "," . $this->point->getLon(), self::POINT);
						$res = $this->load($url, Point::TTL);
						$this->point->setProperties($res);
				}
				return $this->point;
		}

		protected function station(){
				if(!isset($this->station)){
						$this->point();
						$obj = $this->load($this->point->getObservationStations(), Station::TTL);
						$stat = $this->load($obj->observationStations[0], Station::TTL);
						$this->station = new Station();
						$this->station->setProperties($stat);

				}
				if(!$this->station->isLoaded()){
						$url = str_replace("{station}", $this->station->getIdentifier(), self::STATION);
						$res = $this->load($url, Station::TTL);
						$this->station->setProperties($res);
				}
				return $this->station;
		}

		/**
		 * @return array of noaa\ForecastPeriod
		 */
		public function getHourlyForecast(){
				if(!isset($this->hourly)||$this->hourly->isExpired()){
						$this->hourly = $this->forecast($this->point()->getForecastHourly());
				}
				return $this->hourly->getPeriods();
		}

		/**
		 * @return array of noaa\ForecastPeriod
		 */
		public function getDailyForecast(){
				if(!isset($this->daily)||$this->daily->isExpired()){
						$this->point();
						$this->daily = $this->forecast($this->point->getForecast());
				}
				return $this->daily->getPeriods();
		}

		/**
		 * @return noaa\Forecast 
		 */
		protected function forecast($url){
				$res = $this->load($url, Forecast::TTL);
				$forecast = new Forecast();
				$forecast->setProperties($res);
				return $forecast;
		}

		/**
		 * @return array of noaa\Observation
		 */
		public function getObservations(){
				if(!isset($this->observations)){
						$this->station();
						$this->observations = $this->observation($this->station->getObservations());
				}
				return $this->observations->getObservations();
		}

		/**
		 * @param string $url
		 * @return noaa\Observations
		 */
		protected function observation($url){
				$res = $this->load($url, Observations::TTL);
				$observations = new Observations();
				$observations->setProperties($res);
				return $observations;

		}

		/**
		 * @param string $url to load
		 * @param string $ttl for cache expire
		 * @return stdObject results from fetch
		 */
		protected function load($url, $ttl){
				return $this->fetch->load($url, $ttl);
		}
}//class

