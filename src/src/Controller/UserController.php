<?php

namespace App\Controller;

use App\Entity\API\ApiResponseGenerator;
use App\Exception\CreateUserException;
use App\Exception\SearchUserException;
use App\Exception\UpdateUserException;
use App\Service\UserServiceInterface;
use App\Validator\CreateUserValidator;
use App\Validator\SearchUserValidator;
use App\Validator\UpdateUserValidator;
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
        try {
            $users = $this->userService->findAll();
            return (new ApiResponseGenerator())->buildFromUsers($users);
        } catch (SearchUserException $e) {
            return (new ApiResponseGenerator())->buildFromApiException($e);
        }
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
            return (new ApiResponseGenerator())->buildFromApiException($e);
        }

        return (new ApiResponseGenerator())->build(200, 'User successfully created');
    }

    /**
     * @Route("/api/users/{id}", name="users_patch", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateUser(Request $request, UpdateUserValidator $validator, int $id): JsonResponse
    {
        try {
            $dto = $validator->deserialize($request, $id);
            $validator->validate($dto);

            $this->userService->update($dto);
        } catch (UpdateUserException $e) {
            return (new ApiResponseGenerator())->buildFromApiException($e);
        }

        return (new ApiResponseGenerator())->build(200, 'User updated successfully');
    }

    /**
     * @Route("/api/users/parameter/{parameter}/value/{value}", name="users_search", methods={"GET"})
     */
    public function searchUsers(Request $request, SearchUserValidator $validator): JsonResponse
    {
        try {
            $searchDTO = $validator->deserialize($request);
            $validator->validate($searchDTO);

            $users = $this->userService->search($searchDTO);
            return (new ApiResponseGenerator())->buildFromUsers($users);
        } catch (SearchUserException $e) {
            return (new ApiResponseGenerator())->buildFromApiException($e);
        }
    }
}
