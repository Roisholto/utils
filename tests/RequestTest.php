<?php
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase {

  /**
   * @dataProvider jsonDataProvider
   */
  function testparseSearch($a, $b){
    $a = \Roi\Utils\Request::parseSearch() ;
    $this->assertIsArray($a) ;
  }
}
?>
