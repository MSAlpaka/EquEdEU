<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseBookingServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for processing course bookings.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain. Execution is guarded by the <course_booking_api> feature toggle.
 */
final class CourseBookingController extends BaseApiController
{
    public function __construct(
        private readonly CourseBookingServiceInterface $bookingService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    /**
     * Books a course instance for the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function bookAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('course_booking_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);

        $body = (array)$request->getParsedBody();
        $courseInstanceId = isset($body['courseInstance']) ? (int)$body['courseInstance'] : 0;

        if ($userId === null || $courseInstanceId <= 0) {
            return $this->jsonError('api.courseBooking.missingParameters', JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($this->bookingService->isAlreadyBooked($userId, $courseInstanceId)) {
            return $this->jsonError('api.courseBooking.alreadyBooked', JsonResponse::HTTP_CONFLICT);
        }

        $this->bookingService->bookCourse($userId, $courseInstanceId);

        return $this->jsonSuccess([], 'api.courseBooking.success');
    }
}
