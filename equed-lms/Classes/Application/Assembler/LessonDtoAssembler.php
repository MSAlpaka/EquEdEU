<?php

declare(strict_types=1);

namespace Equed\EquedLms\Application\Assembler;

use Equed\EquedLms\Application\Dto\LessonDto;
use Equed\EquedLms\Domain\Model\Lesson;
use Equed\EquedLms\Domain\Model\LessonContentPage;
use Equed\EquedLms\Domain\Model\CourseMaterial;

final class LessonDtoAssembler
{
    public static function fromEntity(Lesson $lesson): LessonDto
    {
        $assets = array_map(
            static fn (CourseMaterial $m): array => [
                'title' => $m->getTitle(),
                'url' => $m->getPublicUrl(),
            ],
            $lesson->getMaterials()->toArray()
        );

        $content = array_map(
            static fn (LessonContentPage $p): array => [
                'type' => $p->getPageType(),
                'value' => $p->getContent(),
                'titleKey' => $p->getTitleKey(),
            ],
            $lesson->getPages()->toArray()
        );

        return new LessonDto(
            (int)$lesson->getUid(),
            $lesson->getTitle(),
            $lesson->getTitleKey(),
            $lesson->getUpdatedAt()?->format(DATE_ATOM),
            $lesson->getModule()?->getCourseProgram()?->getUid(),
            $assets,
            $content,
        );
    }
}
