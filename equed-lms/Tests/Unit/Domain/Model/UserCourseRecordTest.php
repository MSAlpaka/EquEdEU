<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Model {

    use DateTimeImmutable;
    use PHPUnit\Framework\TestCase;
    use Equed\EquedLms\Domain\Model\UserCourseRecord;
    use Equed\EquedLms\Domain\Model\CourseInstance;
    use Equed\EquedLms\Domain\Model\FrontendUser;

    class UserCourseRecordTest extends TestCase
    {
        private UserCourseRecord $subject;

        protected function setUp(): void
        {
            $this->subject = new UserCourseRecord();
        }

        public function testSetAndGetUser(): void
        {
            $user = new FrontendUser();
            $this->subject->setUser($user);
            $this->assertSame($user, $this->subject->getUser());
        }

        public function testSetAndGetCourseInstance(): void
        {
            $instance = new CourseInstance();
            $this->subject->setCourseInstance($instance);
            $this->assertSame($instance, $this->subject->getCourseInstance());
        }

        public function testSetAndGetStatus(): void
        {
            $this->subject->setStatus('validated');
            $this->assertSame('validated', $this->subject->getStatus()->value);
        }

        public function testCertificateIssuedAtSetter(): void
        {
            $date = new DateTimeImmutable('2025-08-15');
            $this->subject->setCertificateIssuedAt($date);
            $this->assertSame($date, $this->subject->getCertificateIssuedAt());
        }

        public function testAttemptNumberAndFinalizedFlag(): void
        {
            $this->subject->setAttemptNumber(2);
            $this->subject->setFinalized(true);

            $this->assertSame(2, $this->subject->getAttemptNumber());
            $this->assertTrue($this->subject->isFinalized());
        }
    }
}
