<?php
namespace noaa\util;
/**
 * class to fetch json data from noaa
 */
use noaa\util\Cache;
use noaa\Point;
use noaa\Forecast;

class Fetch{

		protected $cache;

		public function __construct(Cache $cache){
				$this->cache = $cache;
		}

		/**
		 * @param string $url
		 * @param string $ttl
		 * @see http://php.net/manual/en/dateinterval.construct.php
		 * @return stdObject from json
		 */
		public function load($url, $ttl = "PT1H"){
				if($res = $this->cache->load($url, $ttl)){
				}elseif($res = $this->remote($url)){
						$this->cache->save($url, $res);
				}
				if(!$res){
						throw new \Exception("Unable to fetch url - $url.");
				}
				return json_decode($res);
		}

		/**
		 * @return noaa\util\Cache
		 */
		public function getCache(){
				return $this->cache;
		}

		/**
		 * @param string $url
		 * @return string contents from noaa
		 */
		protected function remote($url){
				$rm = curl_init($url);
				curl_setopt($rm, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($rm, CURLOPT_MAXREDIRS, 20);
				curl_setopt($rm, CURLOPT_RETURNTRANSFER, 20);
				//curl_setopt($rm, CURLOPT_VERBOSE, true);
				$ret = curl_exec($rm);
				curl_close($rm);
				return $ret;
		}
}
