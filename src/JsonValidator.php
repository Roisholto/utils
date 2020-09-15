<?php
namespace Roi\Utils ;

use Validation\SchemaFormats\PhoneNumberFormat ;
use Opis\JsonSchema\{
  Validator,
  ValidationResult,
  ValidationError,
  Schema,
  FormatContainer
};

class JsonValidator {

  private static $instance = null ;
  private $formats ;
  private $filters ;


  private function __construct(){
    // Create a new FormatContainer
    $formats = new FormatContainer();
    // Register our phone number format
    $formats->add("string", "phone-number", new Validation\SchemaFormats\PhoneNumberFormat());

    $this->formats = $formats ;
  }

  public static function getFormats(){
    return self::getInstance()->formats ;
  }
  // Add a new format
  function addFormat($type, $name, $format) : void
    {
    self::getInstance()
        ->formats
        ->add($type, $name, $format) ;
    }

  // add format to validator ;
  public static function setFormat(Validator $Validator){
    $Validator->setFormats(self::getInstance()->formats) ;
    return $Validator ;
  }

  // get validation error ;
  public static function getError(ValidationResult $result) {
    return JsonSchemaError::get($result) ;
  }

  public static function getInstance()
    {
    if(self::$instance == null)
      {
      self::$instance = new self() ;
      }

    return self::$instance ;
    }

  public function __clone()
      {
      throw new \Exception("Can't clone Validator object") ;
      }
}
?>
