<?php
namespace noaa\util;
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
		 * @return mixed string from file or false if not cached
		 */
		public function load($url, $ttl){
				$fname = $this->getFileName($url);
				$ret = false;
				if(file_exists($fname) && !$this->isExpired($fname, $ttl)){
						$ret = file_get_contents($this->getFileName($url));
				}
				return $ret;

		}

		/**
		 * @param string $url source of data
		 * @param string $data to save
		 * @return bool true on success
		 */ 
		public function save($url, $data){
				return file_put_contents($this->getFileName($url), $data) !== false;
		}

		/**
		 * @param string $fname to check
		 * @param string $ttl
		 * @return bool false if file exists and is not expired
		 */
		protected function isExpired($fname, $ttl){
				$mtime = filemtime($fname);
				$mtime = new \DateTime("@$mtime");
				if($mtime->add(new \DateInterval($ttl)) < new \DateTime()){
						$this->delete($fname);
				};
				return !is_writable($fname);
		}

		/**
		 * @param string $fname to delete
		 */
		protected function delete($fname){
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
