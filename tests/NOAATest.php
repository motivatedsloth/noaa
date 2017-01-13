<?php
use PHPUnit\Framework\TestCase;
use noaa\util\Cache;
use noaa\Point;
use noaa\Station;
use noaa\NOAA;

class NOAATest extends TestCase{
		
		function __construct(){
				@mkdir(dirname(__DIR__) . "/cache");
		}

		protected function build(){
				$noaa = new NOAA(new Cache);
				$point = new Point(43.43, -90.80);
				$noaa->setPoint($point);
				return $noaa;
		}
	
		public function testHourly(){
				$noaa = $this->build();
				$hourly = $noaa->getHourlyForecast();
				$this->assertTrue(is_array($hourly));
				$dt = $hourly[0]->getStart();
				$this->assertTrue($dt instanceof \DateTime);
				return $noaa;
		}
				
		/**
		 * @depends testHourly
		 */
		public function testDaily($noaa){
				$daily = $noaa->getDailyForecast();
				$this->assertTrue(is_array($daily));
				$dt = $daily[0]->getStart();
				$this->assertTrue($dt instanceof \DateTime);
				return $noaa;
		}

		/**
		 * @depends testDaily
		 */
		public function testObservationsPoint($noaa){
				$observations = $noaa->getObservations();
				$this->assertTrue(is_array($observations));
				$ob = $observations[0]->getTime();
				$this->assertTrue($ob instanceof \DateTime);
		}

		public function testObservationStation(){
				$noaa = new NOAA(new Cache);
				$noaa->setStation(new Station("KY51"));
				$observations = $noaa->getObservations();
				$this->assertTrue(is_array($observations));
				$ob = $observations[0]->getTime();
				$this->assertTrue($ob instanceof \DateTime);
		}
		
		function __destruct(){
				array_map('unlink', glob(dirname(__DIR__). "/cache/*.tmp"));
				@rmdir(dirname(__DIR__). "/cache");
		}
}
