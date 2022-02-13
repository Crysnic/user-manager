<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\DTO\CreateUserDTO;
use App\Entity\DTO\SearchUserDTO;
use App\Entity\DTO\UpdateUserDTO;
use App\Entity\User;
use App\Exception\CreateUserException;
use App\Exception\SearchUserException;
use App\Exception\UpdateUserException;

interface UserServiceInterface
{
    /**
     * @return User[]
     * @throws SearchUserException
     */
    public function findAll(): array;

    /**
     * @param CreateUserDTO $userDTO
     * @return void
     * @throws CreateUserException
     */
    public function create(CreateUserDTO $userDTO): void;

    /**
     * @param UpdateUserDTO $dto
     * @return void
     * @throws UpdateUserException
     */
    public function update(UpdateUserDTO $dto): void;

    /**
     * @param SearchUserDTO $dto
     * @return User[]
     * @throws SearchUserException
     */
    public function search(SearchUserDTO $dto): array;
}
