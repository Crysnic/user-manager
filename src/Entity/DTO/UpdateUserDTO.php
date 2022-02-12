<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateUserDTO
{
    /**
     * @Assert\NotBlank(message="username - required field", groups={"user_info"})
     * @Assert\Type(type="string", message="password must be a {{ type }}", groups={"user_info"})
     * @Assert\Length(
     *      min = 6,
     *      max = 24,
     *      minMessage = "Your username must be at least {{ limit }} charactes long",
     *      maxMessage = "Your username cannot be longer than {{ limit }} charactes",
     *      groups={"user_info"}
     * )
     * @Assert\Regex(pattern="/^[a-zA-Z_ ]+$/", message="Your username must contain only latin characters", groups={"user_info"})
     *
     * @var string
     */
    private $username;

    /**
     * @Assert\NotBlank(message="password - required field", groups={"password_changing"})
     * @Assert\Type(type="string", message="password must be a {{ type }}", groups={"password_changing"})
     * @Assert\Length(
     *      min = 8,
     *      max = 12,
     *      minMessage = "Your password must be at least {{ limit }} symbols long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} symbols",
     *     groups={"password_changing"}
     * )
     * @Assert\Regex(pattern="/\d/", message="Your password must contain at least one number", groups={"password_changing"})
     * @Assert\Regex(pattern="/[!$_\&\*~\^]/", message="Your password must contain at least one of !$_*~^", groups={"password_changing"})
     * @Assert\Regex(pattern="/[a-z]/", message="Your password must contain at least one letter in lower case", groups={"password_changing"})
     * @Assert\Regex(pattern="/[A-Z]/", message="Your password must contain at least one letter in upper case", groups={"password_changing"})
     * @Assert\Regex(pattern="/^[A-Za-z0-9!$_\&\*~\^]+$/", message="Your password must contain only letters, numbers and !$_*~^", groups={"password_changing"})
     *
     * @var string
     */
    private $password;

    /**
     * @Assert\NotBlank(message="repeatPassword - required field", groups={"password_changing"})
     * @Assert\Type(type="string", message="repeatPassword must be a {{ type }}", groups={"password_changing"})
     * @Assert\EqualTo(propertyPath="password", message="repeatPassword must be equals to password", groups={"password_changing"})
     *
     * @var string
     */
    private $repeatPassword;

    /**
     * @var int
     */
    private $id;

    /**
     * @return string|null
     */
    public function getUsername(): ?string
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
     * @return string|null
     */
    public function getPassword(): ?string
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
     * @return string|null
     */
    public function getRepeatPassword(): ?string
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
