<?php
use PHPUnit\Framework\TestCase;
use noaa\util\Cache;

class CacheTest extends TestCase{

		function __construct(){
				@mkdir(dirname(__DIR__) . "/cache");
		}

		function testSave(){
				$cache = new Cache;
				$this->assertTrue($cache->save("testing", "somedata"));
				return $cache;
		}

		/**
		 * @depends testSave
		 */
		function testLoad($cache){
				$this->assertFalse($cache->load("nonexistent", "PT1H"));
				$this->assertEquals($cache->load("testing", "PT1H"), "somedata");
				sleep(3);
				$this->assertFalse($cache->load("testing", "PT1S"));
		}

		function __destruct(){
				@rmdir(dirname(__DIR__). "/cache");
		}
}
