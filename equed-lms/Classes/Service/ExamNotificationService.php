<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Repository\FrontendUserRepositoryInterface;
use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Domain\Service\ExamNotificationServiceInterface;
use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;

/**
 * Simple implementation that notifies assigned examiners about upcoming exams.
 */
final class ExamNotificationService implements ExamNotificationServiceInterface
{
    public function __construct(
        private readonly CourseInstanceRepositoryInterface $courseInstanceRepository,
        private readonly FrontendUserRepositoryInterface $frontendUserRepository,
        private readonly MailServiceInterface $mailService,
        private readonly LanguageServiceInterface $languageService,
    ) {
    }

    /**
     * Notify all upcoming examiners about their assigned course instances.
     *
     * @return int Number of notifications sent
     */
    public function notifyAll(): int
    {
        $instances = $this->courseInstanceRepository->findAllRequiringExternalExaminer();
        $count = 0;

        foreach ($instances as $instance) {
            $examiner = $instance->getExternalExaminer();
            if ($examiner instanceof FrontendUser && $examiner->getEmail() !== '') {
                $subject = $this->languageService->translate('notification.exam.subject');
                $body = $this->languageService->translate(
                    'notification.exam.body',
                    ['course' => $instance->getTitle()]
                );
                $this->mailService->sendMail($examiner->getEmail(), $subject, $body);
                ++$count;
            }
        }

        return $count;
    }
}
