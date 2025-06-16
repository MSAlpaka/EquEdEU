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
        parent::__construct($configurationService, $apiResponseService, $translationService);
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

        $userId = $this->getCurrentUserId($request);
        $body = (array)$request->getParsedBody();
        $recordId = (int)($body['recordId'] ?? 0);
        $message  = trim((string)($body['message'] ?? ''));
        $type     = trim((string)($body['type'] ?? 'general'));

        if ($userId === null || $recordId <= 0 || $message === '') {
            return $this->jsonError('api.qms.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->qmsService->submitCase($userId, $recordId, $message, $type);

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

        $userId = $this->getCurrentUserId($request);
        $body = (array)$request->getParsedBody();
        $qmsId    = (int)($body['qmsId'] ?? 0);
        $response = trim((string)($body['response'] ?? ''));
        $role     = trim((string)($body['role'] ?? 'certifier'));

        if ($userId === null || $qmsId <= 0 || $response === '') {
            return $this->jsonError('api.qms.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->qmsService->respondToCase($userId, $qmsId, $response, $role);

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

        $userId = $this->getCurrentUserId($request);
        $body = (array)$request->getParsedBody();
        $qmsId = (int)($body['qmsId'] ?? 0);

        if ($userId === null || $qmsId <= 0) {
            return $this->jsonError('api.qms.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->qmsService->closeCase($userId, $qmsId);

        return $this->jsonSuccess([], 'api.qms.closed');
    }
}
// EOF
