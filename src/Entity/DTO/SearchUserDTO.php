<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SearchUserDTO
{
    /**
     * @Assert\NotBlank(allowNull="true", message="username - required field")
     * @Assert\Regex(pattern="/^[a-zA-Z_ ]+$/", message="Your username must contain only latin characters")
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Your username must be at least {{ limit }} charactes long"
     * )
     *
     * @var string|null
     */
    private $username;

    /**
     * @Assert\NotBlank(allowNull="true", message="email - required field")
     * @Assert\Email(message="The email <{{ value }}> is not a valid")
     *
     * @var string|null
     */
    private $email;

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
