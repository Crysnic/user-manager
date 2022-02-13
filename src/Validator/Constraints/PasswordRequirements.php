<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Annotation
 */
class PasswordRequirements extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(null, "password - required field"),
            new Assert\Type('string', 'password must be a {{ type }}'),
            new Assert\Length([
                'min' => 8,
                'max' => 12,
                'minMessage' => 'Your password must be at least {{ limit }} symbols long',
                'maxMessage' => 'Your password cannot be longer than {{ limit }} symbols'
            ]),
            new Assert\Regex('/\d/', 'Your password must contain at least one number'),
            new Assert\Regex('/[!$_\&\*~\^]/', 'Your password must contain at least one of !$_*~^'),
            new Assert\Regex('/[a-z]/', 'Your password must contain at least one letter in lower case'),
            new Assert\Regex('/[A-Z]/', 'Your password must contain at least one letter in upper case'),
            new Assert\Regex('/^[A-Za-z0-9!$_\&\*~\^]+$/', 'Your password must contain only letters, numbers and !$_*~^'),
        ];
    }
}
