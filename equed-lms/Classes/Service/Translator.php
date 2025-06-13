<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Domain\Service\TranslatorInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

final class Translator implements TranslatorInterface
{
    public function translate(string $key, array $arguments = [], ?string $extension = null): ?string
    {
        return LocalizationUtility::translate($key, $extension, $arguments);
    }
}
