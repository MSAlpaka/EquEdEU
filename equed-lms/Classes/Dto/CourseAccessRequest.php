<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use Psr\Http\Message\ServerRequestInterface;

final class CourseAccessRequest
{
    public function __construct(
        private readonly int $userId,
        private readonly int $courseProgramId
    ) {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;

        $params = $request->getQueryParams();
        $programId = isset($params['programId']) ? (int)$params['programId'] : 0;

        return new self($userId, $programId);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCourseProgramId(): int
    {
        return $this->courseProgramId;
    }
}
