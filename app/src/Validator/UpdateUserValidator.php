<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\DTO\UpdateUserDTO;
use App\Exception\UpdateUserException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use UnexpectedValueException;

class UpdateUserValidator
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ValidatorInterface $validator
     */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
        $this->serializer = new Serializer(
            [new ObjectNormalizer()],
            [new JsonEncoder()]
        );
    }

    /**
     * @param Request $request
     * @param int $id
     * @return UpdateUserDTO
     *
     * @throws UpdateUserException
     */
    public function deserialize(Request $request, int $id): UpdateUserDTO
    {
        try {
            /** @var UpdateUserDTO $userDTO */
            $userDTO = $this->serializer->deserialize(
                $request->getContent(),
                UpdateUserDTO::class,
                'json',
                []
            );
            $userDTO->setId($id);
            return $userDTO;
        } catch (UnexpectedValueException $e) {
            throw new UpdateUserException('Invalid JSON', 400);
        }
    }

    /**
     * @param UpdateUserDTO $userDTO
     * @return void
     *
     * @throws UpdateUserException
     */
    public function validate(UpdateUserDTO $userDTO): void
    {
        if ($userDTO->getUsername() !== null) {
            $this->validateGroup($userDTO, ['user_info']);
            return;
        }
        if ($userDTO->getPassword() !== null) {
            $this->validateGroup($userDTO, ['password_changing']);
            return;
        }

        $this->validateGroup($userDTO, ['user_info', 'password_changing']);
    }

    /**
     * @param UpdateUserDTO $userDTO
     * @param array|null $groups
     * @return void
     *
     * @throws UpdateUserException
     */
    private function validateGroup(UpdateUserDTO $userDTO, ?array $groups = null): void
    {
        $errors = $this->validator->validate($userDTO, null, $groups);
        if ($errors->count()) {
            throw new UpdateUserException($errors[0]->getMessage(), 422);
        }
    }
}
