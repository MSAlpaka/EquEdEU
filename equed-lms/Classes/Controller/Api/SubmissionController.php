<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Trait\ErrorResponseTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Helper\AccessHelper;

/**
 * SubmissionController
 *
 * Handles participant submissions (e.g. case reports, documents) and allows instructors/certifiers to evaluate.
 */
final class SubmissionController extends ActionController
{
    use ErrorResponseTrait;

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly GptTranslationServiceInterface $translationService,

        private readonly AccessHelper $accessHelper,
    ) {
    }

    /**
     * Submit a new user submission.
     */
    public function submitAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        if (!is_array($userContext)) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.submission.unauthorized'),
            ], 401);
        }
        $user = $userContext;

        if (!$this->accessHelper->isInstructor($user) && !$this->accessHelper->isAdmin()) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.submission.accessDenied'),
            ], 403);
        }

        $body = $request->getParsedBody();
        $recordId = (int)($body['userCourseRecord'] ?? 0);
        $note = trim((string)($body['note'] ?? ''));
        $file = trim((string)($body['file'] ?? ''));
        $type = trim((string)($body['type'] ?? 'general'));

        if ($recordId <= 0 || $file === '') {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.submission.missingFields'),
            ], 400);
        }

        $connection = $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_usersubmission');
        $connection->insert(
            'tx_equedlms_domain_model_usersubmission',
            [
                'fe_user'           => $user['uid'],
                'usercourserecord'  => $recordId,
                'note'              => $note,
                'file'              => $file,
                'type'              => $type,
                'submitted_at'      => time(),
                'status'            => 'submitted',
                'crdate'            => time(),
                'tstamp'            => time(),
            ]
        );

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.submission.uploaded'),
        ]);
    }

    /**
     * List submissions of current user.
     */
    public function listMineAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        if ($user === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.submission.unauthorized'),
            ], 401);
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

        return new JsonResponse(['status' => 'success', 'submissions' => $submissions]);
    }

    /**
     * List submissions by course record.
     */
    public function listByRecordAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        $recordId = (int)($request->getQueryParams()['recordId'] ?? 0);

        if ($user === null || $recordId <= 0) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.submission.invalidParameters'),
            ], 400);
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

        return new JsonResponse(['status' => 'success', 'submissions' => $results]);
    }

    /**
     * Evaluate a submission.
     */
    public function evaluateAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        if ($user === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.submission.unauthorized'),
            ], 401);
        }

        $body = $request->getParsedBody();
        $submissionId = (int)($body['submissionId'] ?? 0);
        $evaluationNote = trim((string)($body['evaluationNote'] ?? ''));
        $comment = trim((string)($body['instructorComment'] ?? ''));
        $evaluationFile = trim((string)($body['evaluationFile'] ?? ''));

        if ($submissionId <= 0 || $evaluationNote === '') {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.submission.missingInput'),
            ], 400);
        }

        $connection = $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_usersubmission');
        $connection->update(
            'tx_equedlms_domain_model_usersubmission',
            [
                'evaluation_note'     => $evaluationNote,
                'evaluation_file'     => $evaluationFile,
                'instructor_comment'  => $comment,
                'evaluated_by'        => $user['uid'],
                'evaluated_at'        => time(),
                'status'              => 'evaluated',
                'tstamp'              => time(),
            ],
            ['uid' => $submissionId]
        );

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.submission.evaluated'),
        ]);
    }
}
// EOF
