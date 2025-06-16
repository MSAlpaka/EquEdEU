<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\ModuleDto;
use Equed\EquedLms\Domain\Model\Module;

final class ModuleDtoAssembler
{
    public static function fromEntity(Module $module): ModuleDto
    {
        return new ModuleDto(
            (int)$module->getUid(),
            $module->getUuid(),
            $module->getTitle(),
            $module->getTitleKey(),
            $module->getDescription(),
            $module->getDescriptionKey(),
            $module->getIdentifier(),
            $module->getCourseProgram()?->getUid(),
        );
    }
}
