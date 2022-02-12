<?php

declare(strict_types=1);

namespace App\Controller\Validator;

use App\Entity\DTO\CreateUserDTO;
use App\Exception\CreateUserException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use UnexpectedValueException;

class CreateUserValidator
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
     * @return CreateUserDTO
     *
     * @throws CreateUserException
     */
    public function deserialize(Request $request): CreateUserDTO
    {
        try {
            /** @var CreateUserDTO $userDTO */
            return $this->serializer->deserialize(
                $request->getContent(),
                CreateUserDTO::class,
                'json',
                []
            );
        } catch (UnexpectedValueException $e) {
            throw new CreateUserException('Invalid JSON', 400);
        }
    }

    /**
     * @param CreateUserDTO $userDTO
     * @return void
     *
     * @throws CreateUserException
     */
    public function validate(CreateUserDTO $userDTO): void
    {
        $errors = $this->validator->validate($userDTO);
        if ($errors->count()) {
            throw new CreateUserException($errors[0]->getMessage(), 422);
        }
    }
}
