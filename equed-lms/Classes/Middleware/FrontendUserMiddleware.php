<?php

declare(strict_types=1);

namespace Equed\EquedLms\Middleware;

use Equed\EquedLms\Domain\Repository\FrontendUserRepositoryInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Helper\LanguageHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;

/**
 * Middleware to authenticate and inject FrontendUser into request.
 */
final class FrontendUserMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly FrontendUserRepositoryInterface $userRepository,
        private readonly GptTranslationServiceInterface $translationService
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $token = $request->getHeaderLine('X-Api-Token');
        if ($token === '') {
            return new JsonResponse(
                ['error' => 'Missing API token'],
                JsonResponse::STATUS_UNAUTHORIZED
            );
        }

        $user = $this->userRepository->findByApiToken($token);
        if ($user === null) {
            $lang = LanguageHelper::detectLanguage($request->getServerParams());
            $message = $this->translationService->translate('auth_failed', ['_language' => $lang]);

            return new JsonResponse(
                ['error' => $message],
                JsonResponse::STATUS_UNAUTHORIZED
            );
        }

        $request = $request->withAttribute('feUser', $user);

        return $handler->handle($request);
    }
}
// EOF
