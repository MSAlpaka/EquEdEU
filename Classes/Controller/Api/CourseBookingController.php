<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CourseBookingServiceInterface;

/**
 * API controller for processing course bookings.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain. Execution is guarded by the <course_booking_api> feature toggle.
 */
final class CourseBookingController
{
    public function __construct(
        private readonly CourseBookingServiceInterface    $bookingService,
        private readonly ConfigurationServiceInterface    $configurationService,
        private readonly GptTranslationServiceInterface   $translationService
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
        if (!$this->configurationService->isFeatureEnabled('course_booking_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseBooking.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $request->getAttribute('user');
        $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;

        $body = (array)$request->getParsedBody();
        $courseInstanceId = isset($body['courseInstance']) ? (int)$body['courseInstance'] : 0;

        if ($userId === null || $courseInstanceId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseBooking.missingParameters')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        if ($this->bookingService->isAlreadyBooked($userId, $courseInstanceId)) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.courseBooking.alreadyBooked')],
                JsonResponse::HTTP_CONFLICT
            );
        }

        $this->bookingService->bookCourse($userId, $courseInstanceId);

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.courseBooking.success'),
        ]);
    }
}
// End of file
