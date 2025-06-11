<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ExamServiceInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * API controller for loading exam templates and submitting attempts.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <exam_api> feature toggle.
 */
final class ExamController extends ActionController
{
    public function __construct(
        private readonly ExamServiceInterface              $examService,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService,
        private readonly Context                           $context
    ) {
        parent::__construct();
    }

    /**
     * Loads an exam template with its questions.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function loadTemplateAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('exam_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.exam.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $params     = $request->getQueryParams();
        $templateId = isset($params['templateId']) ? (int)$params['templateId'] : 0;
        if ($templateId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.exam.missingTemplateId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $template = $this->examService->loadTemplate($templateId);
        if ($template === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.exam.templateNotFound')],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse([
            'status'   => 'success',
            'template' => $template,
        ]);
    }

    /**
     * Submits an exam attempt and returns the result.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function submitAttemptAction(ServerRequestInterface $request): JsonResponse
    {
        if (! $this->configurationService->isFeatureEnabled('exam_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.exam.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $userContext = $this->context->getAspect('frontend.user')->get('user');
        $userId      = is_array($userContext) && isset($userContext['uid']) ? (int)$userContext['uid'] : null;
        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.exam.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $body       = (array)$request->getParsedBody();
        $templateId = isset($body['templateId']) ? (int)$body['templateId'] : 0;
        $answers    = $body['answers'] ?? [];
        if ($templateId <= 0 || !is_array($answers) || empty($answers)) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.exam.invalidInput')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $result = $this->examService->submitAttempt($userId, $templateId, $answers);

        return new JsonResponse(array_merge(['status' => 'success'], $result));
    }
}
// EOF
