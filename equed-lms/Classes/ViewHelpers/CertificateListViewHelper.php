<?php

declare(strict_types=1);

namespace Equed\EquedLms\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * ViewHelper to render a list of certificates as HTML.
 */
final class CertificateListViewHelper extends AbstractViewHelper
{
    private readonly string $extensionKey;
    private readonly GptTranslationServiceInterface $translationService;

    public function __construct(
        GptTranslationServiceInterface $translationService,
        string $extensionKey = 'equed_lms'
    ) {
        parent::__construct();
        $this->translationService = $translationService;
        $this->extensionKey = $extensionKey;
    }

    public function initializeArguments(): void
    {
        $this->registerArgument(
            'certificates',
            'array',
            'Array of certificate data',
            true
        );
    }

    /**
     * Renders the certificate list or a localized "none found" message.
     *
     * @return string HTML markup
     */
    public function render(): string
    {
        /** @var array<int, array{course_program?: string, cert_number?: string, issued_at?: string}> $certificates */
        $certificates = $this->arguments['certificates'];

        if (empty($certificates)) {
            $message = $this->translate('certificate.list.none') ?? 'No certificates found.';
            return sprintf('<p>%s</p>', htmlspecialchars($message, ENT_QUOTES));
        }

        $output = '<ul class="certificates-list">';
        foreach ($certificates as $certificate) {
            $program = htmlspecialchars((string) ($certificate['course_program'] ?? ''), ENT_QUOTES);
            $number  = htmlspecialchars((string) ($certificate['cert_number'] ?? ''), ENT_QUOTES);
            $date    = htmlspecialchars((string) ($certificate['issued_at'] ?? ''), ENT_QUOTES);

            $output .= sprintf(
                '<li class="certificate-item"><strong>%s</strong> – %s (Issued: %s)</li>',
                $program,
                $number,
                $date
            );
        }
        $output .= '</ul>';

        return $output;
    }

    /**
     * Translate a key via GPT-based service with fallback to core localization.
     */
    private function translate(string $key, array $arguments = []): ?string
    {
        if ($this->translationService->isEnabled()) {
            $translated = $this->translationService->translate($key, $arguments, $this->extensionKey);
            if ($translated !== null && $translated !== $key) {
                return $translated;
            }
        }

        return LocalizationUtility::translate($key, $this->extensionKey, $arguments);
    }
}
// End of file
