<?php
use PHPUnit\Framework\TestCase;
use noaa\util\Cache;

class CacheTest extends TestCase{

  public static function setUpBeforeClass(): void{
    @mkdir(dirname(__DIR__) . "/cache");
  }

  public function testSave(){
    $cache = new Cache;
    $this->assertTrue($cache->save("testing", "somedata"));
    $this->assertEquals("somedata", $cache->load("testing"));
    return $cache;
  }

  /**
   * @depends testSave
   */
  public function testLoad($cache){
    $this->assertEquals("none", $cache->status("nonexistent", "PT1H"));
    $this->assertEquals("fresh", $cache->status("testing", "PT1H"), "somedata");
    sleep(3);
    $this->assertEquals("stale", $cache->status("testing", "PT1S"));
    return $cache;
  }

  /**
   * @depends testLoad
   */
  public function testDelete($cache){
    $cache->delete("testing");
    $this->assertEquals("none", $cache->status("testing", "PT1H"));
  }

  public static function tearDownAfterClass(): void{
    @rmdir(dirname(__DIR__). "/cache");
  }
}
