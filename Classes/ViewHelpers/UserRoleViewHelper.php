<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelper;

use Equed\EquedLms\Service\GptTranslationServiceInterface;
use Equed\EquedLms\Domain\Repository\UserProfileRepositoryInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * ViewHelper to render the role of a user: participant, instructor, or certifier.
 */
final class UserRoleViewHelper extends AbstractViewHelper
{
    private readonly string $extensionKey;
    private readonly GptTranslationServiceInterface $translationService;
    private readonly UserProfileRepositoryInterface $profileRepository;

    public function __construct(
        GptTranslationServiceInterface $translationService,
        UserProfileRepositoryInterface $profileRepository,
        string $extensionKey = 'equed_lms'
    ) {
        parent::__construct();
        $this->translationService    = $translationService;
        $this->profileRepository     = $profileRepository;
        $this->extensionKey          = $extensionKey;
    }

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'userId',
            'int',
            'Frontend user UID',
            true
        );
    }

    /**
     * Returns the localized role label for the given user ID.
     *
     * @return string
     */
    public function render(): string
    {
        $userId = (int)$this->arguments['userId'];
        $profile = $this->profileRepository->findByFeUser($userId);

        $roleKey = 'role.unknown';
        if ($profile !== null) {
            $roleKey = $profile->getIsCertifier()
                ? 'role.certifier'
                : (
                    $profile->getIsInstructor()
                    ? 'role.instructor'
                    : 'role.participant'
                );
        }

        return $this->translate($roleKey) ?? ucfirst(str_replace('role.', '', $roleKey));
    }

    /**
     * Translate via GPT-based service with fallback to core localization.
     */
    private function translate(string $key, array $arguments = []): ?string
    {
        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate(
                $key,
                $arguments,
                $this->extensionKey
            );
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, $this->extensionKey, $arguments);
    }
}
// EOF
