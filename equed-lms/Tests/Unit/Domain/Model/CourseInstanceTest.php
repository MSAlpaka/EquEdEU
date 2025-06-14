<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Model {

    use DateTimeImmutable;
    use PHPUnit\Framework\TestCase;
    use Equed\EquedLms\Domain\Model\CourseInstance;
    use Equed\EquedLms\Domain\Model\CourseProgram;
    use Equed\EquedLms\Domain\Model\FrontendUser;

    class CourseInstanceTest extends TestCase
    {
        private CourseInstance $subject;

        protected function setUp(): void
        {
            $this->subject = new CourseInstance();
        }

        public function testCanSetAndGetStartDate(): void
        {
            $date = new DateTimeImmutable('2025-07-01');
            $this->subject->setStartDate($date);
            $this->assertSame($date, $this->subject->getStartDate());
        }

        public function testCanSetAndGetInstructor(): void
        {
            $user = new FrontendUser();
            $this->subject->setInstructor($user);
            $this->assertSame($user, $this->subject->getInstructor());
        }

        public function testSetAndGetCourseProgram(): void
        {
            $program = new CourseProgram();
            $this->subject->setCourseProgram($program);
            $this->assertSame($program, $this->subject->getCourseProgram());
        }

        public function testSetAndGetLocation(): void
        {
            $this->subject->setLocation('Berlin');
            $this->assertSame('Berlin', $this->subject->getLocation());
        }

        public function testSetAndGetLanguageAndSeatsTotal(): void
        {
            $this->subject->setLanguage(\Equed\EquedLms\Enum\LanguageCode::DE);
            $this->subject->setSeatsTotal(10);

            $this->assertSame(\Equed\EquedLms\Enum\LanguageCode::DE, $this->subject->getLanguage());
            $this->assertSame(10, $this->subject->getSeatsTotal());
        }

        public function testRequiresExternalExaminerFlag(): void
        {
            $this->subject->setRequiresExternalExaminer(true);
            $this->assertTrue($this->subject->requiresExternalExaminer());
        }
    }
}
