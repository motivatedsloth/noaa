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
 * abstract base class
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
abstract class Base {
		/**
		 * Refresh Frequency
		 * @see http://php.net/manual/en/dateinterval.construct.php
		 */
		const TTL = false;

		/**
		 * @var stdObject fetched object from noaa
		 */
		protected $properties;

		/**
		 * @param stdClass properties from noaa
		 * @return mixed $this for fluent interface
		 */
		public function setProperties($properties){
				$this->properties = $properties;
				return $this;
		}

		/**
		 * @return bool true if loaded from noaa
		 */
		public function isLoaded(){
				return isset($this->properties);
		}
}


