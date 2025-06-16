<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

interface CertifierServiceInterface
{
    /**
     * Retrieve validations assigned to a certifier.
     *
     * @return array<int, mixed>
     */
    public function getAssignedValidations(int $certifierId): array;

    /**
     * Approve the specified validation record.
     */
    public function approveValidation(\Equed\EquedLms\Dto\ValidationApproveRequest $request): void;

    /**
     * Reject the specified validation record with feedback.
     */
    public function rejectValidation(\Equed\EquedLms\Dto\ValidationRejectRequest $request): void;
}

// EOF
