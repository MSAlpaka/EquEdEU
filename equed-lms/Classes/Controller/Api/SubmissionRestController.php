<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\SubmissionSyncService;

final class SubmissionRestController extends ActionController
{
    public function __construct(
        private readonly SubmissionSyncService           $submissionService,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context                        $context,
    ) {
        parent::__construct();
    }

    public function exportAction(ServerRequestInterface $request): ResponseInterface
    {
        $userId = (int)($request->getQueryParams()['userId'] ?? 0);
        if ($userId <= 0) {
            $user = $this->context->getAspect('frontend.user')->get('user');
            $userId = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        }
        if ($userId <= 0) {
            return $this->createJsonResponse([
                'error' => $this->translationService->translate('api.submission.invalidUser')
            ], 400);
        }

        try {
            $submissions = $this->submissionService->findByUserId($userId);
            $data = [];
            foreach ($submissions as $submission) {
                $data[] = $this->submissionService->push($submission);
            }
            return $this->createJsonResponse($data);
        } catch (\Throwable $e) {
            return $this->createJsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    public function importAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        if (empty($data['userId'])) {
            $user = $this->context->getAspect('frontend.user')->get('user');
            $data['userId'] = is_array($user) && isset($user['uid']) ? (int)$user['uid'] : 0;
        }
        if (empty($data['userId']) || !isset($data['submission'])) {
            return $this->createJsonResponse([
                'error' => $this->translationService->translate('api.submission.invalidPayload')
            ], 400);
        }

        try {
            $submission = $this->submissionService->pull($data['submission']);
            return $this->createJsonResponse(['status' => 'ok', 'uuid' => $submission->getUuid()]);
        } catch (\Throwable $e) {
            return $this->createJsonResponse(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @param array<int|string, mixed> $data
     */
    protected function createJsonResponse(array $data, int $status = 200): ResponseInterface
    {
        return new JsonResponse($data, $status);
    }
}
