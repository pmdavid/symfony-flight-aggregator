<?php

namespace App\Application\Validator;

use App\Application\Exception\InvalidParamsException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AvailabilityRequestValidator
{
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();
    }

    /**
     * @throws InvalidParamsException
     */
    public function validate(array $input): void
    {
        $constraints = new Assert\Collection([
            'origin' => new Assert\NotBlank(),
            'destination' => new Assert\NotBlank(),
            'date' => [
                new Assert\NotBlank(),
                new Assert\Date()
            ],
        ]);

        $violations = $this->validator->validate($input, $constraints);

        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        if ($errors) throw new InvalidParamsException($errors);
    }
}
