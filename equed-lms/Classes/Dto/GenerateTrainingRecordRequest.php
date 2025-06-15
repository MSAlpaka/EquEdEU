<?php

declare(strict_types=1);

namespace Equed\EquedLms\Dto;

use Psr\Http\Message\ServerRequestInterface;

final class GenerateTrainingRecordRequest
{
    public function __construct(private readonly ?int $courseInstanceId)
    {
    }

    public static function fromRequest(ServerRequestInterface $request): self
    {
        $body = (array)$request->getParsedBody();
        $id = isset($body['courseInstanceId']) ? (int)$body['courseInstanceId'] : null;

        return new self($id);
    }

    public function getCourseInstanceId(): ?int
    {
        return $this->courseInstanceId;
    }
}


