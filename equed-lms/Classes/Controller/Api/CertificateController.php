<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\CertificateRepositoryInterface;
use Equed\EquedLms\Domain\Service\CertificateServiceInterface;
use Equed\EquedLms\Domain\Service\BadgeServiceInterface;

/**
 * API controller for listing certificates, providing download links,
 * and fetching badge data for a user's certificates.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <certificate_api> feature toggle.
 */
final class CertificateController
{
    public function __construct(
        private readonly CertificateRepositoryInterface $certificateRepository,
        private readonly CertificateServiceInterface    $certificateService,
        private readonly BadgeServiceInterface          $badgeService,
        private readonly ConfigurationServiceInterface  $configurationService,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context                        $context
    ) {
    }

    /**
     * Lists all certificates belonging to the authenticated user.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function listAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('certificate_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid'])
            ? (int)$user['uid']
            : null;

        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $certificates = $this->certificateRepository->findByUser($userId);
        $data = array_map(static fn ($cert): array => [
            'id'           => $cert->getUid(),
            'title'        => $cert->getCourseInstance()->getCourseProgram()->getTitle(),
            'issuedAt'     => $cert->getIssuedAt()->format(DATE_ATOM),
            'validUntil'   => $cert->getValidUntil()?->format(DATE_ATOM),
            'code'         => $cert->getCertificateCode(),
            'publicUrl'    => $cert->getPublicUrl(),
            'downloadUrl'  => '/api/certificate/download?certificateId=' . $cert->getUid(),
            'badgeUrl'     => '/api/certificate/badge?certificateId=' . $cert->getUid(),
        ], $certificates);

        return new JsonResponse([
            'status'       => 'success',
            'certificates' => $data,
        ]);
    }

    /**
     * Returns a download URL for a specified certificate.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function downloadAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('certificate_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid'])
            ? (int)$user['uid']
            : null;

        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $params = $request->getQueryParams();
        $certificateId = isset($params['certificateId']) ? (int)$params['certificateId'] : 0;

        if ($certificateId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.invalidId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $filePath = $this->certificateService->getCertificateFilePath($certificateId, $userId);
        if ($filePath === null || !file_exists($filePath)) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.notFound')],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        $downloadUrl = $this->certificateService->getCertificateDownloadUrl($filePath);

        return new JsonResponse([
            'status'      => 'success',
            'downloadUrl' => $downloadUrl,
        ]);
    }

    /**
     * Fetches badge data for a specified certificate.
     *
     * @param ServerRequestInterface $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function badgeAction(ServerRequestInterface $request): JsonResponse
    {
        if (!$this->configurationService->isFeatureEnabled('certificate_api')) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.disabled')],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $user = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($user) && isset($user['uid'])
            ? (int)$user['uid']
            : null;

        if ($userId === null) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.unauthorized')],
                JsonResponse::HTTP_UNAUTHORIZED
            );
        }

        $params = $request->getQueryParams();
        $certificateId = isset($params['certificateId']) ? (int)$params['certificateId'] : 0;

        if ($certificateId <= 0) {
            return new JsonResponse(
                ['error' => $this->translationService->translate('api.certificate.invalidId')],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }

        $badgeData = $this->badgeService->getBadgeData($certificateId, $userId);

        return new JsonResponse([
            'status' => 'success',
            'badge'  => $badgeData,
        ]);
    }
}
// End of file
