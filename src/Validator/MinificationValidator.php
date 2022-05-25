<?php


namespace App\Validator;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class MinificationValidator implements ValidatorInterface
{
    /**
     * @param array $request
     * @return ConstraintViolationListInterface
     */
    public function validation(array $request): ConstraintViolationListInterface
    {
        $fields = [
            'url'       => [new NotBlank(), new NotNull(), new Url],
            'expired'   => [new NotBlank(), new NotNull()],
        ];

        return Validation::createValidator()->validate($request, new Collection(['fields' => $fields]));
    }
}