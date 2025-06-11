<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller\Api;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\BadgeAwardRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for listing badges awarded to the authenticated frontend user.
 *
 * Utilizes hybrid live-translation via {@see GptTranslationServiceInterface}
 * with fallback chain (EN → DE → FR → ES → SW → EASY) for UI labels.
 */
final class BadgeController extends ActionController
{
    public function __construct(
        private readonly BadgeAwardRepositoryInterface  $awardRepository,
        private readonly GptTranslationServiceInterface $translationService,
        private readonly Context                        $context,
    ) {
        parent::__construct();
    }

    /**
     * Displays the list of badges for the current frontend user.
     *
     * @return ResponseInterface
     * @throws \Throwable
     */
    public function listAction(): ResponseInterface
    {
        $userContext = $this->context->getAspect('frontend.user')->get('user');
        $userId = is_array($userContext) && isset($userContext['uid'])
            ? (int)$userContext['uid']
            : 0;

        $badges = $this->awardRepository->findByFeUser($userId);

        $this->view->assignMultiple([
            'badges' => $badges,
        ]);

        return $this->htmlResponse();
    }
}
// End of file
