<?php

namespace TYPO3\CMS\Extbase\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

if (!class_exists(FrontendUser::class)) {
    class FrontendUser extends AbstractEntity
    {
    }
}

namespace TYPO3\CMS\Extbase\Annotation\ORM;

if (!class_exists(ManyToOne::class)) {
    #[\Attribute(\Attribute::TARGET_PROPERTY)]
    class ManyToOne {
        public function __construct(...$args) {}
    }
}

namespace TYPO3\CMS\Extbase\Annotation;

if (!class_exists(Inject::class)) {
    #[\Attribute(\Attribute::TARGET_PROPERTY)]
    class Inject {
        public function __construct(...$args) {}
    }
}

namespace Equed\Core\Service;

interface UuidGeneratorInterface
{
    public function generate(): string;
}

interface ClockInterface
{
    public function now(): \DateTimeImmutable;
}

