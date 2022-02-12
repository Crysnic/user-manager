<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\DTO\CreateUserDTO;
use App\Entity\DTO\UpdateUserDTO;
use App\Entity\User;
use App\Exception\CreateUserException;
use App\Exception\UpdateUserException;

interface UserServiceInterface
{
    /**
     * @return User[]
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
}
