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
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordHasher;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @return array|User[]
     */
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param CreateUserDTO $userDTO
     * @return void
     * @throws CreateUserException
     */
    public function create(CreateUserDTO $userDTO): void
    {
        try {
            $user = $this->buildFromCreateUserDTO($userDTO);

            $this->userRepository->save($user);
        } catch (UniqueConstraintViolationException $e) {
            throw new CreateUserException('User already exists', 409);
        }
    }

    /**
     * @param CreateUserDTO $dto
     * @return User
     */
    private function buildFromCreateUserDTO(CreateUserDTO $dto): User
    {
        $user = new User();
        $user->setEmail($dto->getEmail());
        $user->setUsername($dto->getUsername());

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $dto->getPassword()
        );
        $user->setPassword($hashedPassword);

        return $user;
    }

    /**
     * @param UpdateUserDTO $dto
     * @return void
     *
     * @throws UpdateUserException
     */
    public function update(UpdateUserDTO $dto): void
    {
        $user = $this->userRepository->find($dto->getId());
        if (!$user){
            throw new UpdateUserException('User not found', 404);
        }

        if ($dto->getUsername() !== null) {
            $user->setUsername($dto->getUsername());
        }

        if ($dto->getPassword() !== null) {
            $user->setPassword(
                $this->passwordHasher->hashPassword(
                    $user,
                    $dto->getPassword()
                )
            );
        }

        $this->userRepository->update($user);
    }

    /**
     * @param SearchUserDTO $dto
     * @return User[]
     * @throws SearchUserException
     */
    public function search(SearchUserDTO $dto): array
    {
        if ($dto->getEmail() !== null) {
            $user = $this->userRepository->findOneByEmail($dto->getEmail());
            if ($user === null) {
                throw new SearchUserException('User not found', 404);
            }
            return [$user];
        } elseif ($dto->getUsername() !== null) {
            $users = $this->userRepository->findByUsername($dto->getUsername());
            if (empty($users)) {
                throw new SearchUserException('Users not found', 404);
            }
            return $users;
        } else {
            throw new SearchUserException('Criteria for search not found', 404);
        }
    }
}
