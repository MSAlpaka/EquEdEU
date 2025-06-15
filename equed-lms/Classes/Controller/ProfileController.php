<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\Core\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Service\ProfileService;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for displaying the user profile, including certificates and badges.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY) for messages.
 * Interacts with domain models exclusively through repository interfaces.
 */
final class ProfileController extends ActionController
{
    public function __construct(
        private readonly ProfileService                 $profileService,
        private readonly GptTranslationServiceInterface $translationService
    ) {
        parent::__construct();
    }

    /**
     * Shows the authenticated user’s profile with certificates and badges.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function showAction(): ResponseInterface
    {
        $user = $this->request->getAttribute('user');
        if (!is_array($user) || !isset($user['uid'])) {
            $message = $this->translationService->translate('controller.profile.unauthenticated');
            $accept = $this->request->getHeaderLine('Accept');
            if (str_contains($accept, 'application/json')) {
                return new \TYPO3\CMS\Core\Http\JsonResponse([
                    'error' => $message,
                ], 401);
            }

            $this->addFlashMessage($message, '', AbstractMessage::WARNING);
            return $this->redirect('login');
        }

        $userId = (int)$user['uid'];
        $data = $this->profileService->getProfileData($userId);

        $this->view->assignMultiple([
            'user'         => $user,
            'certificates' => $data['certificates'],
            'badges'       => $data['badges'],
        ]);

        return $this->htmlResponse();
    }
}
// EOF
