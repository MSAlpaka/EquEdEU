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
        $module->setTitleKey('module.intro');
        $module->setDescription('Basics');
        $module->setDescriptionKey('module.desc');
        $module->setIdentifier('M1');

        $lesson = new Lesson();
        $module->addLesson($lesson);

        $this->assertNotEmpty($module->getUuid());
        $this->assertSame('Intro', $module->getTitle());
        $this->assertSame('module.intro', $module->getTitleKey());
        $this->assertSame('Basics', $module->getDescription());
        $this->assertSame('module.desc', $module->getDescriptionKey());
        $this->assertSame('M1', $module->getIdentifier());
        $this->assertInstanceOf(ObjectStorage::class, $module->getLessons());
        $this->assertTrue($module->getLessons()->contains($lesson));
    }
}
