<?php
use PHPUnit\Framework\TestCase;
use noaa\util\Cache;
use noaa\util\Fetch;

class FetchTest extends TestCase{
		function __construct(){
				@mkdir(dirname(__DIR__) . "/cache");
		}
	
		public function testLoad(){
				$cache = new Cache;
				$fetch = new Fetch($cache);
				$url = "https://api.weather.gov/points/43.43,-90.8";
				$this->assertObjectHasAttribute("properties", $fetch->load($url));
		}
				
		function __destruct(){
				@rmdir(dirname(__DIR__). "/cache");
		}
}
