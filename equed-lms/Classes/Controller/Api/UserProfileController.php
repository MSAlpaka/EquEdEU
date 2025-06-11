<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Trait\ErrorResponseTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * UserProfileController
 *
 * Manages user profile retrieval and updates via API.
 */
final class UserProfileController extends ActionController
{
    use ErrorResponseTrait;

    public function __construct(
        private readonly ConnectionPool $connectionPool,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context $context,
    ) {
    }

    /**
     * Get current user profile.
     */
    public function showAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $this->context->getAspect('frontend.user')->get('user');
        $user = is_array($userContext) ? $userContext : null;
        if ($user === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userProfile.unauthorized'),
            ], 401);
        }

        $qb = $this->connectionPool->getQueryBuilderForTable('fe_users');
        $qb->select('uid', 'username', 'name', 'email', 'usergroup')
            ->from('fe_users')
            ->where(
                $qb->expr()->eq('uid', $qb->createNamedParameter((int)$user['uid'], \PDO::PARAM_INT)),
                $qb->expr()->eq('deleted', 0)
            );

        $profile = $qb->executeQuery()->fetchAssociative();
        if ($profile === false) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userProfile.notFound'),
            ], 404);
        }

        return new JsonResponse(['status' => 'success', 'profile' => $profile]);
    }

    /**
     * Update current user profile.
     */
    public function updateAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $this->context->getAspect('frontend.user')->get('user');
        $user = is_array($userContext) ? $userContext : null;
        $body = $request->getParsedBody();
        if ($user === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userProfile.unauthorized'),
            ], 401);
        }

        $fields = [];
        $allowed = ['name', 'email'];
        foreach ($allowed as $field) {
            if (isset($body[$field]) && is_string($body[$field])) {
                $fields[$field] = trim($body[$field]);
            }
        }

        if (empty($fields)) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userProfile.noFields'),
            ], 400);
        }

        $fields['tstamp'] = time();
        $connection = $this->connectionPool->getConnectionForTable('fe_users');
        $connection->update(
            'fe_users',
            $fields,
            ['uid' => (int)$user['uid']]
        );

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.userProfile.updated'),
        ]);
    }
}
// End of file
