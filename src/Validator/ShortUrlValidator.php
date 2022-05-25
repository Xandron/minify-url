<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class ShortUrlValidator implements ValidatorInterface
{
    /**
     * @param array $request
     * @return ConstraintViolationListInterface
     */
    public function validation(array $request): ConstraintViolationListInterface
    {
        $fields = [
            'shortUrl'   => [new NotBlank(), new NotNull()],
        ];

        return Validation::createValidator()->validate($request, new Collection(['fields' => $fields]));
    }
}