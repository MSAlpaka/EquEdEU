<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Service\ProgressService;
use Equed\EquedLms\Trait\ErrorResponseTrait;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\EquedLms\Service\GptTranslationServiceInterface;

/**
 * UserProgressController
 *
 * Provides endpoints to retrieve a user's progress across courses and lessons.
 */
final class UserProgressController extends ActionController
{
    use ErrorResponseTrait;

    public function __construct(
        private readonly ProgressService $progressService,
        private readonly GptTranslationServiceInterface $translationService,

    ) {
    }

    /**
     * GET /api/user/progress
     *
     * @return ResponseInterface
     */
    public function showAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        if ($user === null) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userProgress.unauthorized'),
            ], 401);
        }

        $userId = (int)$user['uid'];
        $data = $this->progressService->getOverallProgressForUser($userId);

        return new JsonResponse([
            'status'   => 'success',
            'progress' => $data,
        ]);
    }

    /**
     * GET /api/user/progress/course?recordId={id}
     *
     * @return ResponseInterface
     */
    public function courseAction(ServerRequestInterface $request): ResponseInterface
    {
        $userContext = $request->getAttribute('user');
        $user = is_array($userContext) ? $userContext : null;
        $params = $request->getQueryParams();
        $recordId = (int)($params['recordId'] ?? 0);

        if ($user === null || $recordId <= 0) {
            return new JsonResponse([
                'error' => $this->translationService->translate('api.userProgress.invalidParameters'),
            ], 400);
        }

        $userId = (int)$user['uid'];
        $data = $this->progressService->getCourseProgress($userId, $recordId);

        return new JsonResponse([
            'status'   => 'success',
            'progress' => $data,
        ]);
    }
}
// EOF
