<?php

declare(strict_types=1);

namespace App\Entity\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SearchUserDTO
{
    const USERNAME = 'username';
    const EMAIL = 'email';
    const PARAMETERS = [self::USERNAME, self::EMAIL];

    /**
     * @Assert\NotBlank(message="parameter - required")
     * @Assert\Choice(choices=SearchUserDTO::PARAMETERS, message="parameter can be only username or email")
     *
     * @var string
     */
    private $parameter;

    /**
     * @Assert\NotBlank(message="value - required field")
     *
     * @Assert\Email(message="The value must contain valid email address", groups={SearchUserDTO::EMAIL})
     *
     * @Assert\Type(type="string", message="value must be a {{ type }}", groups={SearchUserDTO::USERNAME})
     * @Assert\Length(
     *      min = 3,
     *      max = 24,
     *      minMessage = "Your value param should contain part of username with at least {{ limit }} charactes long",
     *      maxMessage = "Your value param should contain username that cannot be longer than {{ limit }} charactes",
     *      groups={SearchUserDTO::USERNAME}
     * )
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z_ ]+$/",
     *     message="Your username must contain only latin characters",
     *     groups={SearchUserDTO::USERNAME}
     * )
     *
     * @var string
     */
    private $value;

    /**
     * @return string
     */
    public function getParameter(): string
    {
        return $this->parameter;
    }

    /**
     * @param string $parameter
     */
    public function setParameter(string $parameter): void
    {
        $this->parameter = $parameter;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}