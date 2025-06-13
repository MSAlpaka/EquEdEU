<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Model\Certificate;
use Equed\EquedLms\Domain\Model\QmsCase;
use Equed\EquedLms\Domain\Model\UserSubmission;
use Equed\EquedLms\Domain\Repository\CertificateRepositoryInterface;
use Equed\EquedLms\Domain\Repository\QmsCaseRepositoryInterface;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;

/**
 * Service to gather dashboard data for a Service Center.
 */
final class ServiceCenterDashboardService
{

    public function __construct(
        private readonly CertificateRepositoryInterface $certificateRepository,
        private readonly UserSubmissionRepositoryInterface $userSubmissionRepository,
        private readonly QmsCaseRepositoryInterface $qmsCaseRepository,
        private readonly LanguageServiceInterface $languageService
    ) {
    }

    public function getDashboardDataForServiceCenter(int $centerId): array
    {
        $certificates = $this->certificateRepository->findPendingByServiceCenter($centerId);
        $submissions  = $this->userSubmissionRepository->findPendingByServiceCenter($centerId);
        $qmsCases     = $this->qmsCaseRepository->findOpenByServiceCenter($centerId);

        return [
            'centerId'     => $centerId,
            'certificates' => $this->mapCertificates($certificates),
            'submissions'  => $this->mapSubmissions($submissions),
            'qmsCases'     => $this->mapQmsCases($qmsCases),
        ];
    }

    private function mapCertificates(array $certificates): array
    {
        return array_map(
            fn (Certificate $c): array => [
                'course'      => $c->getCourse()?->getTitle(),
                'user'        => $c->getFeUser()?->getName(),
                'submittedAt' => $c->getSubmittedAt()?->format('Y-m-d'),
            ],
            $certificates
        );
    }

    private function mapSubmissions(array $submissions): array
    {
        return array_map(
            fn (UserSubmission $s): array => [
                'type'   => $s->getType(),
                'user'   => $s->getFeUser()?->getName(),
                'status' => $this->languageService->translate(
                    match ($s->getStatus()->value) {
                        'pending'    => 'status.pending',
                        'completed'  => 'status.completed',
                        'inProgress' => 'status.inProgress',
                        default      => 'status.unknown',
                    }
                ),
            ],
            $submissions
        );
    }

    private function mapQmsCases(array $cases): array
    {
        return array_map(
            fn (QmsCase $q): array => [
                'title'  => $q->getTitle(),
                'status' => $this->languageService->translate(
                    match ($q->getStatus()) {
                        'pending'    => 'status.pending',
                        'completed'  => 'status.completed',
                        'inProgress' => 'status.inProgress',
                        default      => 'status.unknown',
                    }
                ),
                'date'   => $q->getDate()?->format('Y-m-d'),
            ],
            $cases
        );
    }

}
