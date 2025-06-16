<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Controller\Api\BaseApiController;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Domain\Service\CertifierServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Dto\ValidationApproveRequest;
use Equed\EquedLms\Dto\ValidationRejectRequest;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;

/**
 * API controller for certifier actions: listing, approving and rejecting course validations.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <certifier_validation> feature toggle.
 */
final class CertifierController extends BaseApiController
{
    public function __construct(
        private readonly CertifierServiceInterface $certifierService,
        ConfigurationServiceInterface $configurationService,
        ApiResponseServiceInterface $apiResponseService,
        GptTranslationServiceInterface $translationService,
    ) {
    }

    /**
     * Lists validations assigned to the authenticated certifier.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function assignedValidationsAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('certifier_validation')) !== null) {
            return $check;
        }

        $certifierId = $this->getCurrentUserId($request);
        if ($certifierId === null) {
            return $this->jsonError('api.certifier.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $validations = $this->certifierService->getAssignedValidations($certifierId);

        return $this->jsonSuccess([
            'validations' => $validations,
        ]);
    }

    /**
     * Approves a validation and triggers certification.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function approveValidationAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('certifier_validation')) !== null) {
            return $check;
        }

        try {
            $dto = ValidationApproveRequest::fromRequest($request);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('api.certifier.invalidParameters', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->certifierService->approveValidation($dto);

        return $this->jsonSuccess([
            'message' => $this->translationService->translate('api.certifier.approved'),
        ]);
    }

    /**
     * Rejects a validation with feedback.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function rejectValidationAction(ServerRequestInterface $request): JsonResponse
    {
        if (($check = $this->requireFeature('certifier_validation')) !== null) {
            return $check;
        }

        try {
            $dto = ValidationRejectRequest::fromRequest($request);
        } catch (\InvalidArgumentException) {
            return $this->jsonError('api.certifier.invalidParameters', JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->certifierService->rejectValidation($dto);

        return $this->jsonSuccess([
            'message' => $this->translationService->translate('api.certifier.rejected'),
        ]);
    }
}
