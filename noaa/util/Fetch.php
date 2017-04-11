<?php
namespace noaa\util;
/**
 * class to fetch json data from noaa
 */
use noaa\util\Cache;
use noaa\Point;
use noaa\Forecast;
use Exception;

class Fetch{
        /** @var noaa\util\Cache */
		protected $cache;

        /**
         * string to use for useragent, will be an api key in future
         * 
         * @see https://forecast-v3.weather.gov/documentation 
         * API Reference tab, Authentication section
         *
         * @var string
         */
        protected $key;

		public function __construct(Cache $cache, $key = "my_noaa_app"){
				$this->cache = $cache;
                $this->key = $key;
		}

		/**
		 * @param string $url
		 * @param string $ttl
		 * @see http://php.net/manual/en/dateinterval.construct.php
		 * @return stdObject from json
		 */
		public function load($url, $ttl = "PT1H"){
				$status = $this->cache->status($url, $ttl);
				if($status != "fresh"){ //stale or none
						$res = $this->remote($url);
						if($res){
								$this->cache->save($url, $res);
								return json_decode($res);
						}
				}
				if($status == "none"){
						throw new Exception("Unable to fetch url - $url.");
				}
				//return from cache
				return json_decode($this->cache->load($url));
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
				curl_setopt($rm, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($rm, CURLOPT_AUTOREFERER, true);
				curl_setopt($rm, CURLOPT_RETURNTRANSFER, 20);
                curl_setopt($rm, CURLOPT_USERAGENT, $this->key);
				//curl_setopt($rm, CURLOPT_VERBOSE, true);
				$ret = curl_exec($rm);
				if(curl_getinfo($rm, CURLINFO_HTTP_CODE) == 500){
						throw new Exception("Server error 500 from weather at url: $url");
				}
				curl_close($rm);
				return $ret;
		}
}
