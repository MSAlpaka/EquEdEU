<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Helper\AccessHelper;
use Equed\EquedLms\Domain\Repository\UserSubmissionRepositoryInterface;
use Equed\EquedLms\Service\SubmissionService;
use Equed\EquedLms\Dto\SubmissionCreateRequest;
use Equed\EquedLms\Dto\SubmissionEvaluateRequest;

/**
 * SubmissionController
 *
 * Handles participant submissions (e.g. case reports, documents) and allows instructors/certifiers to evaluate.
 */
final class SubmissionController extends BaseApiController
{

    public function __construct(
        private readonly UserSubmissionRepositoryInterface $submissionRepository,
        private readonly SubmissionService $submissionService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
        private readonly AccessHelper $accessHelper,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * Submit a new user submission.
     */
    public function submitAction(ServerRequestInterface $request): ResponseInterface
    {
        if (($check = $this->requireFeature('submission_api')) !== null) {
            return $check;
        }

        $userContext = $request->getAttribute('user');
        if (!is_array($userContext)) {
            return $this->jsonError('api.submission.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }
        $user = $userContext;

        if (!$this->accessHelper->isInstructor($user) && !$this->accessHelper->isAdmin()) {
            return $this->jsonError('api.submission.accessDenied', JsonResponse::HTTP_FORBIDDEN);
        }

        $dto = SubmissionCreateRequest::fromRequest($request);

        try {
            $this->submissionService->createSubmission($dto);
        } catch (\InvalidArgumentException $e) {
            return $this->jsonError('api.submission.missingFields', JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->jsonSuccess([], 'api.submission.uploaded');
    }

    /**
     * List submissions of current user.
     */
    public function listMineAction(ServerRequestInterface $request): ResponseInterface
    {
        if (($check = $this->requireFeature('submission_api')) !== null) {
            return $check;
        }

        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        if ($user === null) {
            return $this->jsonError('api.submission.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $submissions = $this->submissionRepository->fetchAllByFeUser($user['uid']);

        return $this->jsonSuccess(['submissions' => $submissions]);
    }

    /**
     * List submissions by course record.
     */
    public function listByRecordAction(ServerRequestInterface $request): ResponseInterface
    {
        if (($check = $this->requireFeature('submission_api')) !== null) {
            return $check;
        }

        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        $recordId = (int)($request->getQueryParams()['recordId'] ?? 0);

        if ($user === null || $recordId <= 0) {
            return $this->jsonError('api.submission.invalidParameters', JsonResponse::HTTP_BAD_REQUEST);
        }

        $submissions = $this->submissionRepository->fetchAllByRecord($recordId);

        return $this->jsonSuccess(['submissions' => $submissions]);
    }

    /**
     * Evaluate a submission.
     */
    public function evaluateAction(ServerRequestInterface $request): ResponseInterface
    {
        if (($check = $this->requireFeature('submission_api')) !== null) {
            return $check;
        }

        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        if ($user === null) {
            return $this->jsonError('api.submission.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $dto = SubmissionEvaluateRequest::fromRequest($request);

        try {
            $this->submissionService->evaluateSubmission($dto);
        } catch (\InvalidArgumentException $e) {
            return $this->jsonError('api.submission.missingInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->jsonSuccess([], 'api.submission.evaluated');
    }
}
// EOF
