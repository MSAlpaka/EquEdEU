<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\TrainingRecordGeneratorInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for generating training-record certificates.
 *
 * All human-readable messages are translated via {@see GptTranslationServiceInterface}
 * to leverage hybrid live-translation with fallback logic.
 * Execution is guarded by the <training_record_generation> feature toggle.
 */
final class AppCertificateController
{
    public function __construct(
        private readonly TrainingRecordGeneratorInterface       $trainingRecordGenerator,
        private readonly UserCourseRecordRepositoryInterface    $userCourseRecordRepository,
        private readonly ConfigurationServiceInterface          $configurationService,
        private readonly GptTranslationServiceInterface         $translationService,
    ) {
    }

    /**
     * Generates a ZIP file containing the training-record certificate for a
     * completed course enrollment of the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable Propagates unexpected domain exceptions.
     */
    public function generateTrainingRecordAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('training_record_generation')) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.trainingRecord.disabled'),
            ], 403);
        }

        $user = $request->getAttribute('user');
        if ($user === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.trainingRecord.unauthorized'),
            ], 401);
        }

        $body = (array)$request->getParsedBody();
        $courseInstanceId = isset($body['courseInstanceId']) ? (int)$body['courseInstanceId'] : null;
        if ($courseInstanceId === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.trainingRecord.missingCourseId'),
            ], 400);
        }

        $record = $this->userCourseRecordRepository
            ->findOneByUserAndCourseInstance((int)$user['uid'], $courseInstanceId);

        if ($record === null || !$record->isCompleted()) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.trainingRecord.notFound'),
            ], 404);
        }

        $program = $record->getCourseInstance()->getCourseProgram();
        $certificateData = [
            'cert_number' => $record->getCertificateNumber(),
            'course'      => $program?->getTitle() ?? '',
            'issued_on'   => $record->getCompletionDate()?->format('Y-m-d') ?? '',
        ];

        $filePath = $this->trainingRecordGenerator->generateZip($certificateData);

        return new JsonResponse([
            'status'    => 'success',
            'file_path' => $filePath,
        ]);
    }
}
// End of file
