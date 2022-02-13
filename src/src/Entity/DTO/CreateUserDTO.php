<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;

class CreateUserDTO
{
    /**
     * @Assert\NotBlank(message="email - required field")
     * @Assert\Email(message="The email <{{ value }}> is not a valid")
     *
     * @var string
     */
    private $email;

    /**
     * @Assert\NotBlank(message="username - required field")
     * @Assert\Type(type="string", message="password must be a {{ type }}")
     * @Assert\Length(
     *      min = 6,
     *      max = 24,
     *      minMessage = "Your username must be at least {{ limit }} charactes long",
     *      maxMessage = "Your username cannot be longer than {{ limit }} charactes"
     * )
     * @Assert\Regex(pattern="/^[a-zA-Z_ ]+$/", message="Your username must contain only latin characters")
     *
     * @var string
     */
    private $username;

    /**
     * @AppAssert\PasswordRequirements()
     *
     * @var string
     */
    private $password;

    /**
     * @Assert\NotBlank(message="repeatPassword - required field")
     * @Assert\Type(type="string", message="repeatPassword must be a {{ type }}")
     * @Assert\EqualTo(propertyPath="password", message="repeatPassword must be equals to password")
     *
     * @var string
     */
    private $repeatPassword;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getRepeatPassword(): string
    {
        return $this->repeatPassword;
    }

    /**
     * @param string $repeatPassword
     */
    public function setRepeatPassword(string $repeatPassword): void
    {
        $this->repeatPassword = $repeatPassword;
    }
}
