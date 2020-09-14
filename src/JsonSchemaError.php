<?php
namespace Roi\Utils ;
use OpisErrorPresenter\Contracts\PresentedValidationError;
use OpisErrorPresenter\Implementation\MessageFormatterFactory;
use OpisErrorPresenter\Implementation\PresentedValidationErrorFactory;
use OpisErrorPresenter\Implementation\ValidationErrorPresenter;

use Opis\JsonSchema\{
    Validator, ValidationResult, ValidationError, Schema
};

class JsonSchemaError {

  static function get(ValidationResult $result) : array
    {
      // Default strategy is AllErrors
    $presenter = new ValidationErrorPresenter(
        new PresentedValidationErrorFactory(
            new MessageFormatterFactory()
        )
    );

    $presented = $presenter->present(...$result->getErrors());

    // Inspected presenter error
    array_map(static function (PresentedValidationError $error) {
        return $error->toArray();
    }, $presented);

    return $presented ;
    }
}
