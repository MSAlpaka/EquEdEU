<?php

declare(strict_types=1);

namespace Equed\EquedLms\Controller;

use Equed\EquedLms\Service\CourseProgressServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
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
        private readonly CourseProgressServiceInterface $courseProgressService
    ) {
    }

    /**
     * Displays the selected course and calculates the user's progress.
     */
    public function showAction(ServerRequestInterface $request): ResponseInterface
    {
        $courseUid = (int)($this->settings['course'] ?? 0);
        $userAttr = $request->getAttribute('user');
        $userId   = is_array($userAttr) && isset($userAttr['uid']) ? (int)$userAttr['uid'] : 0;

        $viewModel = $this->courseProgressService->getCourseViewModel($courseUid, $userId);

        if ($viewModel->hasError()) {
            $this->addFlashMessage(
                $viewModel->getError() ?? '',
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            return $this->redirect('list');
        }

        $this->view->assignMultiple([
            'course'   => $viewModel->getCourse(),
            'progress' => $viewModel->getProgress(),
        ]);

        return $this->htmlResponse();
    }
}
