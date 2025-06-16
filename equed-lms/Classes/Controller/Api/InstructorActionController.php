<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\InstructorServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for instructor-only actions: completing courses and uploading evaluations.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <instructor_actions_api> feature toggle.
 */
final class InstructorActionController extends BaseApiController
{
    public function __construct(
        private readonly InstructorServiceInterface $instructorService,
        ConfigurationServiceInterface           $configurationService,
        ApiResponseServiceInterface             $apiResponseService,
        GptTranslationServiceInterface          $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
    }

    /**
     * Marks a user course record as completed by the instructor.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function completeCourseAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('instructor_actions_api')) !== null) {
            return $check;
        }

        $instructorId = $this->getCurrentUserId($request);
        if ($instructorId === null) {
            return $this->jsonError('api.instructor.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        if ($recordId <= 0) {
            return $this->jsonError('api.instructor.invalidRecordId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $success = $this->instructorService->completeCourse($recordId, $instructorId);
        if (! $success) {
            return $this->jsonError('api.instructor.accessDenied', JsonResponse::HTTP_FORBIDDEN);
        }

        return $this->jsonSuccess([], 'api.instructor.courseCompleted');
    }

    /**
     * Uploads an evaluation note for a user course record.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function uploadEvaluationAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('instructor_actions_api')) !== null) {
            return $check;
        }

        $instructorId = $this->getCurrentUserId($request);
        if ($instructorId === null) {
            return $this->jsonError('api.instructor.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        $note = isset($body['evaluationNote']) ? trim((string)$body['evaluationNote']) : '';
        if ($recordId <= 0 || $note === '') {
            return $this->jsonError('api.instructor.invalidInput', JsonResponse::HTTP_BAD_REQUEST);
        }

        $success = $this->instructorService->uploadEvaluation($recordId, $instructorId, $note);
        if (! $success) {
            return $this->jsonError('api.instructor.accessDenied', JsonResponse::HTTP_FORBIDDEN);
        }

        return $this->jsonSuccess([], 'api.instructor.evaluationUploaded');
    }
}
// EOF
