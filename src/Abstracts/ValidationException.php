<?php

namespace App\Abstracts;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class ValidationException extends Exception 
{

    public function __construct(
        private ConstraintViolationListInterface $errors, 
        string $message = '', int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): ConstraintViolationListInterface 
    {
        return $this->errors;
    }
}
