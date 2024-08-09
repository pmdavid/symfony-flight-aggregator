<?php

namespace App\Application\Exception;

use Symfony\Component\HttpFoundation\Response;

class InvalidParamsException extends \Exception
{
    private array $errors;

    public function __construct(array $errors, $message = 'Invalid/Missing parameters', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}
