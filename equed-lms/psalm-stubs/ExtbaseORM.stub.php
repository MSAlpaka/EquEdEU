<?php
namespace TYPO3\CMS\Extbase\Annotation\ORM;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ManyToOne
{
    public function __construct(...$args) {}
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class Lazy
{
    public function __construct(...$args) {}
}
