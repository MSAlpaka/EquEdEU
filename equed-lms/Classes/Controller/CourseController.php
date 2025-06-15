<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\EquedLms\Service\CourseProgressServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * Controller for displaying course details and tracking user progress.
 *
 * Utilizes GPT-based translation service for all human-readable output,
 * supporting hybrid live translation with fallback (EN → DE → FR → ES → SW → EASY).
 */
final class CourseController extends ActionController
{
    public function __construct(
        private readonly CourseProgressServiceInterface $courseProgressService,
        private readonly Context $context
    ) {
        parent::__construct();
    }

    /**
     * Displays the selected course and calculates the user's progress.
     */
    public function showAction(ServerRequestInterface $request): ResponseInterface
    {
        $courseUid = (int)($this->settings['course'] ?? 0);
        $userId = (int)$this->context->getAspect('frontend.user')->get('id');

        $data = $this->courseProgressService->getCourseViewModel($courseUid, $userId);

        if (isset($data['error'])) {
            $this->addFlashMessage(
                $data['error'],
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            return $this->redirect('list');
        }

        $this->view->assignMultiple($data);

        return $this->htmlResponse();
    }
}
// End of file
