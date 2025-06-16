<?php

declare(strict_types=1);

namespace Equed\EquedLms\Middleware;

use Equed\EquedLms\Domain\Repository\CourseAccessMapRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Helper\LanguageHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;

/**
 * Middleware to enforce access control for course instances.
 */
final class CourseAccessMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly CourseAccessMapRepositoryInterface $accessMapRepository,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $userAttr = $request->getAttribute('user');
        $userId   = is_object($userAttr) && method_exists($userAttr, 'getUid')
            ? $userAttr->getUid()
            : (is_array($userAttr) && isset($userAttr['uid']) ? (int)$userAttr['uid'] : 0);
        $courseInstanceId = (int)$request->getAttribute('courseInstance');

        if ($userId <= 0 || $courseInstanceId <= 0) {
            return new JsonResponse(
                ['error' => 'Invalid request'],
                JsonResponse::STATUS_BAD_REQUEST
            );
        }

        $accessList = $this->accessMapRepository->findByFeUser($userId);
        $hasAccess = false;

        foreach ($accessList as $access) {
            if ($access->getCourseProgram()?->getUid() === $courseInstanceId
                || $access->getCourseInstance()?->getUid() === $courseInstanceId) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            $lang = LanguageHelper::detectLanguage($request->getServerParams());
            $message = $this->translationService->translate('access_denied', ['_language' => $lang]);

            return new JsonResponse(
                ['error' => $message],
                JsonResponse::STATUS_FORBIDDEN
            );
        }

        return $handler->handle($request);
    }
}
// EOF
