<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\QmsApiService;
use Equed\EquedLms\Dto\QmsSubmitRequest;
use Equed\EquedLms\Dto\QmsRespondRequest;
use Equed\EquedLms\Dto\QmsCloseRequest;

/**
 * API controller for managing QMS cases.
 *
 * - Instructors submit QMS cases
 * - ServiceCenter/Certifier respond and close cases
 * - Full audit logging via QMS domain model
 */
final class QmsController extends BaseApiController
{
    public function __construct(
        private readonly QmsApiService $qmsService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    /**
     * List QMS cases submitted by current user (Instructor/Admin).
     */
    public function listAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('qms_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.qms.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $cases = $this->qmsService->getCasesForUser($userId);

        return $this->jsonSuccess(['cases' => $cases]);
    }

    /**
     * Submit a new QMS case.
     */
    public function submitAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('qms_api')) !== null) {
            return $check;
        }

        try {
            $dto = QmsSubmitRequest::fromRequest($request);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('api.qms.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->qmsService->submitCase($dto);

        return $this->jsonSuccess([], 'api.qms.submitted');
    }

    /**
     * Respond to an existing QMS case.
     */
    public function respondAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('qms_api')) !== null) {
            return $check;
        }

        try {
            $dto = QmsRespondRequest::fromRequest($request);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('api.qms.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->qmsService->respondToCase($dto);

        return $this->jsonSuccess([], 'api.qms.responded');
    }

    /**
     * Close a QMS case.
     */
    public function closeAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('qms_api')) !== null) {
            return $check;
        }

        try {
            $dto = QmsCloseRequest::fromRequest($request);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('api.qms.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->qmsService->closeCase($dto);

        return $this->jsonSuccess([], 'api.qms.closed');
    }
}
