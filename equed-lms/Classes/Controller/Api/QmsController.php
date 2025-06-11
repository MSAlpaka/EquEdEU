<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * API controller for managing QMS cases.
 *
 * - Instructors submit QMS cases
 * - ServiceCenter/Certifier respond and close cases
 * - Full audit logging via QMS domain model
 */
final class QmsController extends ActionController
{
    public function __construct(
        private readonly ConnectionPool                    $connectionPool,
        private readonly Context                           $context,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService
    ) {
        parent::__construct();
    }

    /**
     * List QMS cases submitted by current user (Instructor/Admin).
     */
    public function listAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('qms_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.qms.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = (is_array($user) && isset($user['uid'])) ? (int)$user['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.qms.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $qb = $this->connectionPool->getQueryBuilderForTable('tx_equedlms_domain_model_qms');
        $cases = $qb
            ->select('uid', 'usercourserecord', 'type', 'message', 'status', 'submitted_at', 'responded_at', 'closed_at')
            ->from('tx_equedlms_domain_model_qms')
            ->where(
                $qb->expr()->eq('submitted_by', $qb->createNamedParameter($userId, \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            )
            ->orderBy('submitted_at', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative();

        return new JsonResponse(['status' => 'success', 'cases' => $cases]);
    }

    /**
     * Submit a new QMS case.
     */
    public function submitAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('qms_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.qms.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }
        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = (is_array($user) && isset($user['uid'])) ? (int)$user['uid'] : null;
        $body = (array)$request->getParsedBody();
        $recordId = (int)($body['recordId'] ?? 0);
        $message  = trim((string)($body['message'] ?? ''));
        $type     = trim((string)($body['type'] ?? 'general'));

        if ($userId === null || $recordId <= 0 || $message === '') {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.qms.invalidInput')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $now = time();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->insert(
                'tx_equedlms_domain_model_qms',
                [
                    'usercourserecord' => $recordId,
                    'submitted_by'     => $userId,
                    'type'             => $type,
                    'message'          => $message,
                    'status'           => 'open',
                    'submitted_at'     => $now,
                    'tstamp'           => $now,
                    'crdate'           => $now
                ]
            );

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.qms.submitted')
        ]);
    }

    /**
     * Respond to an existing QMS case.
     */
    public function respondAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('qms_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.qms.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }
        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = (is_array($user) && isset($user['uid'])) ? (int)$user['uid'] : null;
        $body = (array)$request->getParsedBody();
        $qmsId    = (int)($body['qmsId'] ?? 0);
        $response = trim((string)($body['response'] ?? ''));
        $role     = trim((string)($body['role'] ?? 'certifier'));

        if ($userId === null || $qmsId <= 0 || $response === '') {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.qms.invalidInput')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $now = time();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->update(
                'tx_equedlms_domain_model_qms',
                [
                    'response'       => $response,
                    'responded_by'   => $userId,
                    'responded_role' => $role,
                    'responded_at'   => $now,
                    'status'         => 'responded',
                    'tstamp'         => $now
                ],
                ['uid' => $qmsId]
            );

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.qms.responded')
        ]);
    }

    /**
     * Close a QMS case.
     */
    public function closeAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('qms_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.qms.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }
        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = (is_array($user) && isset($user['uid'])) ? (int)$user['uid'] : null;
        $body = (array)$request->getParsedBody();
        $qmsId = (int)($body['qmsId'] ?? 0);

        if ($userId === null || $qmsId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.qms.invalidInput')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $now = time();
        $this->connectionPool->getConnectionForTable('tx_equedlms_domain_model_qms')
            ->update(
                'tx_equedlms_domain_model_qms',
                [
                    'status'    => 'closed',
                    'closed_by' => $userId,
                    'closed_at' => $now,
                    'tstamp'    => $now
                ],
                ['uid' => $qmsId]
            );

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.qms.closed')
        ]);
    }
}
// EOF
