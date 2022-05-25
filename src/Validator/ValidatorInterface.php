<?php

namespace App\Validator;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Interface EntityInterface
 * @package App\Entity\Main
 */
interface ValidatorInterface
{
    /**
     * @param array $request
     * @return ConstraintViolationListInterface
     */
    public function validation(array $request): ConstraintViolationListInterface;
}
