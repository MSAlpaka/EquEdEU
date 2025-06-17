<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Model;

use TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup as ExtbaseFrontendUserGroup;

/**
 * Frontend user group model implementing {@see TitleAwareGroupInterface}.
 */
final class FrontendUserGroup extends ExtbaseFrontendUserGroup implements TitleAwareGroupInterface
{
}
