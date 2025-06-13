<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\ExamNotificationService;
use Equed\EquedLms\Domain\Repository\CourseInstanceRepositoryInterface;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Service\MailServiceInterface;
use Equed\EquedLms\Domain\Model\CourseInstance;
use Equed\EquedLms\Domain\Model\FrontendUser;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;

class ExamNotificationServiceTest extends TestCase
{
    use ProphecyTrait;

    private ExamNotificationService $subject;
    private $repo;
    private $language;
    private $mail;

    protected function setUp(): void
    {
        $this->repo = $this->prophesize(CourseInstanceRepositoryInterface::class);
        $this->language = $this->prophesize(LanguageServiceInterface::class);
        $this->mail = $this->prophesize(MailServiceInterface::class);

        $this->subject = new ExamNotificationService(
            $this->repo->reveal(),
            $this->prophesize(\Equed\EquedLms\Domain\Repository\FrontendUserRepositoryInterface::class)->reveal(),
            $this->mail->reveal(),
            $this->language->reveal(),
        );
    }

    public function testNotifyAllSendsTranslatedMailToExaminer(): void
    {
        $examiner = $this->prophesize(FrontendUser::class);
        $examiner->getEmail()->willReturn('ex@example.com');
        $instance = $this->prophesize(CourseInstance::class);
        $instance->getExternalExaminer()->willReturn($examiner->reveal());
        $instance->getTitle()->willReturn('Course');

        $this->repo->findAllRequiringExternalExaminer()->willReturn([$instance->reveal()]);

        $this->language->translate('notification.exam.subject')->willReturn('sub');
        $this->language->translate('notification.exam.body', ['course' => 'Course'])->willReturn('body');

        $this->mail->sendMail('ex@example.com', 'sub', 'body')->shouldBeCalled();

        $count = $this->subject->notifyAll();
        $this->assertSame(1, $count);
    }
}
