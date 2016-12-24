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
use noaa\Point;

/**
 * Describes an observation station
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Station extends Base{
		/**
		 * Refresh Frequency
		 * @see http://php.net/manual/en/dateinterval.construct.php
		 */
		const TTL = "P1D";

		/**
		 * @var string station identifier
		 */
		protected $ident;

		/**
		 * @param string $ident optional station identifier
		 */
		public function __construct($ident = null){
				if($ident){
						$this->ident = $ident;
				}
		}

		/**
		 * @return string name
		 */
		public function getName(){
				return $this->properties->properties->name;
		}

		/**
		 * @return string identifier
		 */
		public function getIdentifier(){
				return $this->ident?$this->ident:$this->properties->properties->stationIdentifier;
		}

		/**
		 * @return string timezone
		 */
		public function getTimezone(){
				return $this->properties->properties->timeZone;
		}

		/**
		 * @return string url to observations
		 * @throws \Exception if not loaded
		 */
		public function getObservations(){
				if(!$this->isLoaded()){
						throw new \Exception("Station info not loaded, couldn't create Observations");
				}
				return $this->properties->id . "/observations";
		}

		/**
		 * @return noaa\Point;
		 * @throws \Exception if not loaded
		 */
		public function getPoint(){
				if(!$this->isLoaded()){
						throw new \Exception("Station info not loaded, couldn't create Point");
				}
				$lat = $this->properties->geometry->coordinates[1];
				$lon = $this->properties->geometry->coordinates[0];
				return new Point($lat, $lon);
		}
}
