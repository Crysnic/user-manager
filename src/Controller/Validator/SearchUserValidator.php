<?php

declare(strict_types=1);

namespace App\Controller\Validator;

use App\Entity\DTO\SearchUserDTO;
use App\Exception\SearchUserException;
use Symfony\Component\HttpFoundation\Request;
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
        if ($request->query->has('username')) {
            $searchUser->setUsername($request->query->get('username'));
        }
        if ($request->query->has('email')) {
            $searchUser->setEmail($request->query->get('email'));
        }

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
        $errors = $this->validator->validate($dto);
        if ($errors->count()) {
            throw new SearchUserException($errors[0]->getMessage(), 422);
        }
    }
}
