<?php
namespace Roi\Utils\Validation\SchemaFormats ;

use Opis\JsonSchema\IFormat ;
use Roi\Utils\Validation ;

class PhoneNumberFormat implements IFormat
{
  public function validate($data): bool {
    $rs = Validation::validatePhone($data) ;
    if(!$rs)
      return false ;
    return true;
  }
}
?>
