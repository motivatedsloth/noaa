<?php
namespace noaa\util;
use RuntimeException;
use DateInterval;
use DateTime;

/**
 * class to cache json data from noaa
 */

/**
 * @param string $dir directory name of cache
 * @throws Exception if directory is not writable
 */
class Cache{
		/**
		 * @var string full directory path
		 */
		protected $dir = "";

		public function __construct($dir = "cache"){
				$this->dir = realpath($dir);
				if(!is_writable($this->dir)){
						throw new \Exception("Cache directory \"$dir\" is not writable.");
				}
		}

		/**
		 * @param string $url source of data
		 * @param string $ttl for DateInterval constructor
		 * @see http://php.net/manual/en/dateinterval.construct.php
		 * @return string "fresh", "stale", "none"
		 */
		public function status($url, $ttl){
				$fname = $this->getFileName($url);
				$status = "none";
				if(!file_exists($fname)){
						return $status;
				}
				$status = "stale";
				if($this->isExpired($fname, $ttl)){
						return $status;
				}
				return "fresh";
		}

		/**
		 * @param string $url source of data
		 * @return mixed string from file or false if not cached
		 * @throws RuntimeException if file does not exist
		 */
		public function load($url){
				$fname = $this->getFileName($url);
				if(file_exists($fname)){
						return file_get_contents($this->getFileName($url));
				}
				throw new RuntimeException("File for $url not in cache");
		}

		/**
		 * @param string $url source of data
		 * @param string $data to save
		 * @return bool true on success
		 */ 
		public function save($url, $data){
				$fname = $this->getFileName($url);
				return file_put_contents($fname, $data) !== false;
		}

		/**
		 * @param string $fname to check
		 * @param string $ttl
		 * @return bool false if file exists and is not expired
		 */
		protected function isExpired($fname, $ttl){
				$mtime = filemtime($fname);
				$mtime = new DateTime("@$mtime");
				return $mtime->add(new DateInterval($ttl)) < new DateTime();
		}

		/**
		 * @param string $fname to delete
		 */
		public function delete($url){
				$fname = $this->getFileName($url);
				return unlink($fname);
		}

		/**
		 * create file name for given $url
		 * @param string $url
		 */
		protected function getFileName($url){
				return $this->dir . "/" . str_replace("/", "_", $url) . ".tmp";
		}
}
