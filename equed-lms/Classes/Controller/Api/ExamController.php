<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\ExamServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for loading exam templates and submitting attempts.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <exam_api> feature toggle.
 */
final class ExamController extends BaseApiController
{
    public function __construct(
        private readonly ExamServiceInterface           $examService,
        ConfigurationServiceInterface                  $configurationService,
        ApiResponseServiceInterface                    $apiResponseService,
        GptTranslationServiceInterface                 $translationService,
    ) {
    }

    /**
     * Loads an exam template with its questions.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function loadTemplateAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('exam_api')) !== null) {
            return $check;
        }

        $params     = $request->getQueryParams();
        $templateId = isset($params['templateId']) ? (int)$params['templateId'] : 0;
        if ($templateId <= 0) {
            return $this->jsonError('api.exam.missingTemplateId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $template = $this->examService->loadTemplate($templateId);
        if ($template === null) {
            return $this->jsonError('api.exam.templateNotFound', JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->jsonSuccess(['template' => $template]);
    }

    /**
     * Submits an exam attempt and returns the result.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     */
    public function submitAttemptAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('exam_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.exam.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $body       = (array)$request->getParsedBody();
        $templateId = isset($body['templateId']) ? (int)$body['templateId'] : 0;
        $answers    = $body['answers'] ?? [];
        if ($templateId <= 0 || !is_array($answers) || empty($answers)) {
            return $this->jsonError('api.exam.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $result = $this->examService->submitAttempt($userId, $templateId, $answers);

        return $this->jsonSuccess($result);
    }
}
