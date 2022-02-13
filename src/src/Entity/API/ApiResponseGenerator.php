<?php

declare(strict_types=1);

namespace App\Entity\API;

use App\Entity\User;
use App\Exception\ApiException;
use stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseGenerator
{
    /**
     * @param ApiException $exception
     * @return JsonResponse
     */
    public function buildFromApiException(ApiException $exception): JsonResponse
    {
        return new JsonResponse($this->buildBody($exception->getMessage()), $exception->getCode());
    }

    /**
     * @param int $code
     * @param string $message
     * @return JsonResponse
     */
    public function build(int $code, string $message): JsonResponse
    {
        return new JsonResponse($this->buildBody($message), $code);
    }

    /**
     * @param User[] $users
     * @param int $code
     * @return JsonResponse
     */
    public function buildFromUsers(array $users, int $code = 200): JsonResponse
    {
        $body = $this->buildBody('');
        $body->users = [];
        foreach ($users as $user) {
            $body->users[] = $user->jsonSerialize();
        }

        return new JsonResponse($body, $code);
    }

    /**
     * @param string $message
     * @return stdClass
     */
    private function buildBody(string $message): stdClass
    {
        $body = new stdClass();
        if ($message !== '') {
            $body->message = $message;
        }
        return $body;
    }
}
