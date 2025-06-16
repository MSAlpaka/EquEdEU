<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Domain\Repository\UserCourseRecordRepositoryInterface;
use Equed\EquedLms\Domain\Service\TrainingRecordGeneratorInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Dto\GenerateTrainingRecordRequest;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\Core\Service\ConfigurationServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for generating training-record certificates.
 *
 * All human-readable messages are translated via {@see GptTranslationServiceInterface}
 * to leverage hybrid live-translation with fallback logic.
 * Execution is guarded by the <training_record_generation> feature toggle.
 */
final class AppCertificateController extends BaseApiController
{
    public function __construct(
        private readonly TrainingRecordGeneratorInterface $trainingRecordGenerator,
        private readonly UserCourseRecordRepositoryInterface $userCourseRecordRepository,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
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
        if (($check = $this->requireFeature('training_record_generation')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.trainingRecord.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $dto = GenerateTrainingRecordRequest::fromRequest($request);
        $courseInstanceId = $dto->getCourseInstanceId();
        if ($courseInstanceId === null) {
            return $this->jsonError('api.trainingRecord.missingCourseId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $record = $this->userCourseRecordRepository
            ->findOneByUserAndCourseInstance($userId, $courseInstanceId);

        if ($record === null || ! $record->isCompleted()) {
            return $this->jsonError('api.trainingRecord.notFound', JsonResponse::HTTP_NOT_FOUND);
        }

        $data = $this->trainingRecordGenerator->createCertificateData($record);
        $filePath = $this->trainingRecordGenerator->generateZip($data);

        return $this->jsonSuccess(['file_path' => $filePath]);
    }
}
