<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\DTO\SearchUserDTO;
use App\Exception\SearchUserException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchUserValidator
{
    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function deserialize(Request $request): SearchUserDTO
    {
        $searchUser = new SearchUserDTO();
        $searchUser->setParameter($request->attributes->get('parameter'));
        $searchUser->setValue($request->attributes->get('value'));

        return $searchUser;
    }

    /**
     * @param SearchUserDTO $dto
     * @return void
     *
     * @throws SearchUserException
     */
    public function validate(SearchUserDTO $dto): void
    {
        $errors = $this->validator->validate($dto, null, ['Default']);
        $this->processErrors($errors);

        $errors = $this->validator->validate($dto, null, [$dto->getParameter()]);
        $this->processErrors($errors);
    }

    /**
     * @throws SearchUserException
     */
    private function processErrors(ConstraintViolationListInterface $errors): void
    {
        if ($errors->count()) {
            throw new SearchUserException($errors[0]->getMessage(), 422);
        }
    }
}
