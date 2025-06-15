<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Service\CertifierServiceInterface;

/**
 * API controller for certifier actions: listing, approving and rejecting course validations.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <certifier_validation> feature toggle.
 */
final class CertifierController
{
    public function __construct(
        private readonly CertifierServiceInterface        $certifierService,
        private readonly ConfigurationServiceInterface     $configurationService,
        private readonly GptTranslationServiceInterface    $translationService,
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
        if (!$this->configurationService->isFeatureEnabled('certifier_validation')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certifier.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $request->getAttribute('user');
        $certifierId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;
        if ($certifierId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certifier.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $validations = $this->certifierService->getAssignedValidations($certifierId);

        return new JsonResponse([
            'status'      => 'success',
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
        if (!$this->configurationService->isFeatureEnabled('certifier_validation')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certifier.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;

        $user = $request->getAttribute('user');
        $certifierId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;

        if ($certifierId === null || $recordId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certifier.invalidParameters')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $this->certifierService->approveValidation($recordId, $certifierId);

        return new JsonResponse([
            'status'  => 'success',
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
        if (!$this->configurationService->isFeatureEnabled('certifier_validation')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certifier.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $body = (array)$request->getParsedBody();
        $recordId = isset($body['recordId']) ? (int)$body['recordId'] : 0;
        $feedback = isset($body['feedback']) ? trim((string)$body['feedback']) : '';

        $user = $request->getAttribute('user');
        $certifierId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : null;

        if ($certifierId === null || $recordId <= 0 || $feedback === '') {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certifier.invalidParameters')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $this->certifierService->rejectValidation($recordId, $feedback, $certifierId);

        return new JsonResponse([
            'status'  => 'success',
            'message' => $this->translationService->translate('api.certifier.rejected'),
        ]);
    }
}
// EOF
