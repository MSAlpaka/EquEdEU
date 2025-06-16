<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\UserCourseRecordCrudServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Dto\UserCourseRecordUpdateRequest;

/**
 * UserCourseRecordController
 *
 * Manages UserCourseRecord CRUD and status updates via API.
 */
final class UserCourseRecordController extends BaseApiController
{
    public function __construct(
        private readonly UserCourseRecordCrudServiceInterface $recordService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * List all course records for current user.
     */
    public function listAction(ServerRequestInterface $request): JsonResponse
    {
        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.userCourseRecord.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $records = $this->recordService->listForUser($userId);

        return $this->jsonSuccess([
            'records' => $records,
        ]);
    }

    /**
     * View single course record details.
     */
    public function showAction(ServerRequestInterface $request): JsonResponse
    {
        $userId = $this->getCurrentUserId($request);
        $id = (int)($request->getQueryParams()['uid'] ?? 0);
        if ($userId === null || $id <= 0) {
            return $this->jsonError('api.userCourseRecord.invalidParameters', JsonResponse::HTTP_BAD_REQUEST);
        }

        $record = $this->recordService->getForUser($userId, $id);
        if ($record === null) {
            return $this->jsonError('api.userCourseRecord.notFound', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->jsonSuccess([
            'record' => $record,
        ]);
    }

    /**
     * Update status/progress of a course record.
     */
    public function updateAction(ServerRequestInterface $request): JsonResponse
    {
        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.userCourseRecord.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $dto = UserCourseRecordUpdateRequest::fromRequest($request);

        if ($dto->getUid() <= 0 || $dto->getStatus() === '') {
            return $this->jsonError('api.userCourseRecord.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->recordService->updateRecord($userId, $dto);

        return $this->jsonSuccess([], 'api.userCourseRecord.updated');
    }

    /**
     * Delete a course record (soft-delete).
     */
    public function deleteAction(ServerRequestInterface $request): JsonResponse
    {
        $userId = $this->getCurrentUserId($request);
        $id = (int)($request->getQueryParams()['uid'] ?? 0);
        if ($userId === null || $id <= 0) {
            return $this->jsonError('api.userCourseRecord.invalidParameters', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->recordService->deleteRecord($userId, $id);

        return $this->jsonSuccess([], 'api.userCourseRecord.deleted');
    }
}
// End of file
