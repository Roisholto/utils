<?php
use PHPUnit\Framework\TestCase;

use Opis\JsonSchema\{
    Validator, ValidationResult, ValidationError, Schema
};

final class JsonValidatorTest extends TestCase {

  /**
   * @dataProvider jsonDataProvider
   */
  function testSchema($a, $b){
    $Schema = Schema::fromJsonString(file_get_contents(__DIR__.'/request-pin.json') ) ;
    $validator = \Roi\Utils\JsonValidator::getInstance()->setFormat(new Validator()) ;
    $result = $validator->schemaValidation(json_decode(json_encode($b)), $Schema) ;
    if($a)
      {
      $this->assertTrue($result->isValid()) ;
      }
    else
      {
      $this->assertFalse($result->isValid()) ;
      $error = \Roi\Utils\JsonValidator::getInstance()->getError($result) ;
      // print_r($error) ;
      $this->assertIsArray($error) ;
      }

  }

  function jsonDataProvider(){
    return [
      [true, ['name'=>'ayo', 'phone'=>'+2348052670273', 'competition_round_id'=>1]],
      [false, ['name'=>'', 'phone'=>'08052670273', 'competition_round_id'=>1]],
    ] ;
  }

}
?>
