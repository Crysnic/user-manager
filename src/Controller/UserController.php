<?php

namespace App\Controller;

use App\Controller\Validator\CreateUserValidator;
use App\Controller\Validator\UpdateUserValidator;
use App\Exception\CreateUserException;
use App\Exception\UpdateUserException;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/api/users", name="users", methods={"GET"})
     */
    public function getUsers(): JsonResponse
    {
        return $this->json(
            $this->userService->findAll()
        );
    }

    /**
     * @Route("/api/users", name="users_add", methods={"POST"})
     */
    public function addUser(Request $request, CreateUserValidator $validator): JsonResponse
    {
        try {
            $userDTO = $validator->deserialize($request);
            $validator->validate($userDTO);

            $this->userService->create($userDTO);
        } catch (CreateUserException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }

        return $this->json('User successfully created');
    }

    /**
     * @Route("/api/users/{id}", name="users_patch", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateUser(Request $request, UpdateUserValidator $validator, int $id): JsonResponse
    {
        try {
            $userDTO = $validator->deserialize($request, $id);
            $validator->validate($userDTO);

            $this->userService->update($userDTO);
        } catch (UpdateUserException $e) {
            return $this->json($e->getMessage(), $e->getCode());
        }

        return $this->json('User updated successfully');
    }

    /**
     * @Route("/api/users/search", name="users_search", methods={"GET"})
     */
    public function searchUsers(Request $request): JsonResponse
    {
        return $this->json(
            $this->userService->findAll()
        );
    }
}
