<?php
use PHPUnit\Framework\TestCase;

final class ValidationTest extends TestCase {

  /**
   * @dataProvider falsePhoneNumberProvider
   */
  function testValidatePhoneFalse($a, $b){
    $a =  \Roi\Utils\Validation::validatePhone($a, $b) ;
    $this->assertFalse($a) ;
  }
  /**
     * @dataProvider truePhoneNumberProvider
     */
  function testValidatePhoneTrue($a, $b){
    $a =  \Roi\Utils\Validation::validatePhone($a, $b) ;
    $this->assertIsArray($a) ;
  }

  public function falsePhoneNumberProvider()
    {
    return [
        ['+234897992', null]

      ];
    }

  public function truePhoneNumberProvider(){
    return [
      ['08052670274', 'NG'],
      ['+2348039284083', null]
    ] ;
  }
}
