<?php

namespace App\Controller;

use App\Entity\DTO\CreateUserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use UnexpectedValueException;

class UserController extends AbstractController
{
    /**
     * @Route("/api/users", name="users", methods={"GET"})
     */
    public function getUsers(UserRepository $userRepository): JsonResponse
    {
        return $this->json(
            $userRepository->findAll()
        );
    }

    /**
     * @Route("/api/users", name="users_add", methods={"POST"})
     */
    public function addUser(
        Request $request,
        ValidatorInterface $validator,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse
    {
        try {
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            $serializer = new Serializer($normalizers, $encoders);

            /** @var CreateUserDTO $userDTO */
            $userDTO = $serializer->deserialize(
                $request->getContent(),
                CreateUserDTO::class,
                'json',
                []
            );
        } catch (UnexpectedValueException $e) {
            return $this->json('Invalid JSON', 422);
        }

        $errors = $validator->validate($userDTO);
        if ($errors->count()) {
            return $this->json(['error' => $errors[0]->getMessage()], 422);
        }

        try {
            $user = User::buildFromDTO($userDTO);
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $userDTO->getPassword()
            );
            $user->setPassword($hashedPassword);

            $em->persist($user);
            $em->flush();
        } catch (UniqueConstraintViolationException $e) {
            return $this->json('User already exists', 409);
        }

        return $this->json('User successfully created');
    }
}
