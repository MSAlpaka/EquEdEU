<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\Core\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\CertificateRepositoryInterface;
use Equed\EquedLms\Domain\Repository\BadgeRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
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
        private readonly CertificateRepositoryInterface   $certificateRepository,
        private readonly BadgeRepositoryInterface         $badgeRepository,
        private readonly GptTranslationServiceInterface   $translationService,
        private readonly Context                          $context
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
        $user = $this->context->getAspect('frontend.user')->get('user');
        if (!is_array($user) || !isset($user['uid'])) {
            $message = $this->translationService->translate('controller.profile.unauthenticated');
            $this->addFlashMessage($message, '', AbstractMessage::WARNING);
            return $this->redirect('login');
        }

        $userId = (int)$user['uid'];
        $certificates = $this->certificateRepository->findByUser($userId);
        $badges = $this->badgeRepository->findByUser($userId);

        $this->view->assignMultiple([
            'user'         => $user,
            'certificates' => $certificates,
            'badges'       => $badges,
        ]);

        return $this->htmlResponse();
    }
}
// EOF
