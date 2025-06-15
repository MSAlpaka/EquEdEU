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

/**
 * UserCourseRecordController
 *
 * Manages UserCourseRecord CRUD and status updates via API.
 */
final class UserCourseRecordController extends ActionController
{
    use ErrorResponseTrait;

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly GptTranslationServiceInterface $translationService,

    ) {
    }

    /**
     * List all course records for current user.
     */
    public function listAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        if ($user === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userCourseRecord.unauthorized'),
            ], 401);
        }

        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_usercourserecord');
        $qb->select('uid', 'course_instance', 'status', 'progress', 'validated', 'feedback_submitted')
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($user['uid'], \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('tstamp', 'DESC');

        $records = $qb->executeQuery()->fetchAllAssociative();

        return new JsonResponse(['status' => 'success', 'records' => $records]);
    }

    /**
     * View single course record details.
     */
    public function showAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        $id = (int)($request->getQueryParams()['uid'] ?? 0);
        if ($user === null || $id <= 0) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userCourseRecord.invalidParameters'),
            ], 400);
        }

        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_usercourserecord');
        $qb->select('*')
            ->from('tx_equedlms_domain_model_usercourserecord')
            ->where(
                $qb->expr()->eq('uid', $qb->createNamedParameter($id, \PDO::PARAM_INT)),
                $qb->expr()->eq('fe_user', $qb->createNamedParameter($user['uid'], \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            );

        $record = $qb->executeQuery()->fetchAssociative();
        if ($record === false) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userCourseRecord.notFound'),
            ], 404);
        }

        return new JsonResponse(['status' => 'success', 'record' => $record]);
    }

    /**
     * Update status/progress of a course record.
     */
    public function updateAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        $body = $request->getParsedBody();
        $id = (int)($body['uid'] ?? 0);
        $status = trim((string)($body['status'] ?? ''));
        $progress = isset($body['progress']) ? (int)$body['progress'] : null;

        if ($user === null || $id <= 0 || $status === '') {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userCourseRecord.invalidInput'),
            ], 400);
        }

        $data = ['status' => $status, 'tstamp' => time()];
        if ($progress !== null) {
            $data['progress'] = $progress;
        }

        $connection = $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_usercourserecord');
        $connection->update(
            'tx_equedlms_domain_model_usercourserecord',
            $data,
            ['uid' => $id, 'fe_user' => $user['uid']]
        );

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.userCourseRecord.updated'),
        ]);
    }

    /**
     * Delete a course record (soft-delete).
     */
    public function deleteAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        $id = (int)($request->getQueryParams()['uid'] ?? 0);
        if ($user === null || $id <= 0) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userCourseRecord.invalidParameters'),
            ], 400);
        }

        $connection = $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_usercourserecord');
        $connection->update(
            'tx_equedlms_domain_model_usercourserecord',
            ['deleted' => 1, 'tstamp' => time()],
            ['uid' => $id, 'fe_user' => $user['uid']]
        );

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.userCourseRecord.deleted'),
        ]);
    }
}
// End of file
