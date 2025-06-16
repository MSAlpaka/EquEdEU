<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use Equed\Core\Service\ConfigurationServiceInterface;
use Equed\EquedLms\Domain\Service\ApiResponseServiceInterface;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\CertificateRepositoryInterface;
use Equed\EquedLms\Domain\Service\CertificateServiceInterface;
use Equed\EquedLms\Domain\Service\BadgeServiceInterface;
use Equed\EquedLms\Application\Assembler\CertificateDtoAssembler;
use Equed\EquedLms\Controller\Api\BaseApiController;

/**
 * API controller for listing certificates, providing download links,
 * and fetching badge data for a user's certificates.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY).
 * Execution is guarded by the <certificate_api> feature toggle.
 */
final class CertificateController extends BaseApiController
{
    public function __construct(
        private readonly CertificateRepositoryInterface $certificateRepository,
        private readonly CertificateServiceInterface    $certificateService,
        private readonly BadgeServiceInterface          $badgeService,
        ConfigurationServiceInterface                  $configurationService,
        ApiResponseServiceInterface                    $apiResponseService,
        GptTranslationServiceInterface                 $translationService,
    ) {
        parent::__construct($configurationService, $apiResponseService, $translationService);
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
        if (($check = $this->requireFeature('certificate_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.certificate.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $certificates = $this->certificateRepository->findByUser($userId);
        $data = CertificateDtoAssembler::fromEntities($certificates);

        return $this->jsonSuccess([
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
        if (($check = $this->requireFeature('certificate_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.certificate.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $params = $request->getQueryParams();
        $certificateId = isset($params['certificateId']) ? (int)$params['certificateId'] : 0;

        if ($certificateId <= 0) {
            return $this->jsonError('api.certificate.invalidId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $filePath = $this->certificateService->getCertificateFilePath($certificateId, $userId);
        if ($filePath === null || !file_exists($filePath)) {
            return $this->jsonError('api.certificate.notFound', JsonResponse::HTTP_NOT_FOUND);
        }

        $downloadUrl = $this->certificateService->getCertificateDownloadUrl($filePath);

        return $this->jsonSuccess([
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
        if (($check = $this->requireFeature('certificate_api')) !== null) {
            return $check;
        }

        $userId = $this->getCurrentUserId($request);
        if ($userId === null) {
            return $this->jsonError('api.certificate.unauthorized', JsonResponse::HTTP_UNAUTHORIZED);
        }

        $params = $request->getQueryParams();
        $certificateId = isset($params['certificateId']) ? (int)$params['certificateId'] : 0;

        if ($certificateId <= 0) {
            return $this->jsonError('api.certificate.invalidId', JsonResponse::HTTP_BAD_REQUEST);
        }

        $badgeData = $this->badgeService->getBadgeData($certificateId, $userId);

        return $this->jsonSuccess([
            'badge' => $badgeData,
        ]);
    }
}
// End of file

