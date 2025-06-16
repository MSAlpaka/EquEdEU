<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Helper\AccessHelper;
use Equed\EquedLms\Service\SubmissionService;

/**
 * SubmissionController
 *
 * Handles participant submissions (e.g. case reports, documents) and allows instructors/certifiers to evaluate.
 */
final class SubmissionController extends BaseApiController
{

    public function __construct(
        private readonly ConnectionPool $connectionPool,
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

        $body = $request->getParsedBody();
        $recordId = (int)($body['userCourseRecord'] ?? 0);
        $note = trim((string)($body['note'] ?? ''));
        $file = trim((string)($body['file'] ?? ''));
        $type = trim((string)($body['type'] ?? 'general'));

        if ($recordId <= 0 || $file === '') {
            return $this->jsonError('api.submission.missingFields', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->submissionService->createSubmission($user['uid'], $recordId, $note, $file, $type);

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

        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_usersubmission');
        $qb->select('uid', 'usercourserecord', 'type', 'note', 'file', 'status', 'submitted_at', 'evaluated_at', 'evaluation_note')
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($user['uid'], \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('submitted_at', 'DESC');

        $submissions = $qb->executeQuery()->fetchAllAssociative();

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

        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_usersubmission');
        $qb->select('*')
            ->from('tx_equedlms_domain_model_usersubmission')
            ->where(
                $qb->expr()->eq('usercourserecord', $qb->createNamedParameter($recordId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('submitted_at', 'DESC');

        $results = $qb->executeQuery()->fetchAllAssociative();

        return $this->jsonSuccess(['submissions' => $results]);
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

        $body = $request->getParsedBody();
        $submissionId = (int)($body['submissionId'] ?? 0);
        $evaluationNote = trim((string)($body['evaluationNote'] ?? ''));
        $comment = trim((string)($body['instructorComment'] ?? ''));
        $evaluationFile = trim((string)($body['evaluationFile'] ?? ''));

        if ($submissionId <= 0 || $evaluationNote === '') {
            return $this->jsonError('api.submission.missingInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->submissionService->evaluateSubmission($submissionId, $evaluationNote, $evaluationFile, $comment, $user['uid']);

        return $this->jsonSuccess([], 'api.submission.evaluated');
    }
}
// EOF
