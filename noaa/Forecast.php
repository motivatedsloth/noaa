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
use noaa\ForecastPeriod;
use DateTime;
use DateInterval;

/**
 * class to manage a collection of ForecastPeriods
 */
class Forecast extends Base{
		/**
		 * refresh frequency
		 * @see http://php.net/manual/en/dateinterval.construct.php
		 */
		const TTL = "PT1H";

		/**
		 * @return array of ForecastPeriods
		 */
		public function getPeriods(){
				$ret = array();
				foreach($this->properties->properties->periods as $period){
						$ret[] = new ForecastPeriod($period);
				}
				return $ret;
		}

		/**
		 * @return DateTime time of forecast
		 */
		public function getUpdated(){
				return new DateTime($this->properties->properties->updated);
		}

		/**
		 * @return bool true if forecast is older than update frequency
		 */
		public function isExpired(){
				return $this->getUpdated()->add(new DateInterval(self::TTL)) < new DateTime();
		}
}//class
