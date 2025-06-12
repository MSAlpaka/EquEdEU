<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Domain\Model\Module;
use Equed\EquedLms\Domain\Model\Lesson;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class ModuleTest extends TestCase
{
    public function testModuleGettersAndRelations(): void
    {
        $module = new Module();
        $module->setTitle('Intro');
        $module->setDescription('Basics');
        $module->setIdentifier('M1');

        $lesson = new Lesson();
        $module->addLesson($lesson);

        $this->assertNotEmpty($module->getUuid());
        $this->assertSame('Intro', $module->getTitle());
        $this->assertSame('Basics', $module->getDescription());
        $this->assertSame('M1', $module->getIdentifier());
        $this->assertInstanceOf(ObjectStorage::class, $module->getLessons());
        $this->assertTrue($module->getLessons()->contains($lesson));
    }
}
