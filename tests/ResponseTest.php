<?php
use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase {

  /**
   * @dataProvider jsonDataProvider
   */
  function testCreate($a, $b){
    $a = \Roi\Utils\Response::create('1', 'truth test') ;
    $this->assertArrayHasKey('status', $a) ;
    $this->assertSame(1, $a['status']) ;
    $a = \Roi\Utils\Response::create('00', 'truth test') ;
    $this->assertArrayHasKey('status', $a) ;
    $this->assertSame(0, $a['status']) ;

  }

  function jsonDataProvider(){
    return [
      [true, ['name'=>'ayo', 'phone'=>'+2348052670273', 'competition_round_id'=>1]],
      [false, ['name'=>'', 'phone'=>'08052670273', 'competition_round_id'=>1]],
    ] ;
  }

}
?>
