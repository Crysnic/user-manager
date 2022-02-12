<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO
{
    /**
     * @Assert\NotBlank(message="email - required field")
     * @Assert\Email(message="The email <{{ value }}> is not a valid")
     *
     * @param string
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
     * @param string
     */
    private $username;

    /**
     * @Assert\NotBlank(message="password - required field")
     * @Assert\Type(type="string", message="password must be a {{ type }}")
     * @Assert\Length(
     *      min = 8,
     *      max = 12,
     *      minMessage = "Your password must be at least {{ limit }} symbols long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} symbols"
     * )
     * @Assert\Regex(pattern="/\d/", message="Your password must contain at least one number")
     * @Assert\Regex(pattern="/[!$_\&\*~\^]/", message="Your password must contain at least one of !$_*~^")
     * @Assert\Regex(pattern="/[a-z]/", message="Your password must contain at least one letter in lower case")
     * @Assert\Regex(pattern="/[A-Z]/", message="Your password must contain at least one letter in upper case")
     * @Assert\Regex(pattern="/^[A-Za-z0-9!$_\&\*~\^]+$/", message="Your password must contain only letters, numbers and !$_*~^")
     *
     * @param string
     */
    private $password;

    /**
     * @Assert\NotBlank(message="repeatPassword - required field")
     * @Assert\Type(type="string", message="repeatPassword must be a {{ type }}")
     * @Assert\EqualTo(propertyPath="password", message="repeatPassword must be equals to password")
     *
     * @param string
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
