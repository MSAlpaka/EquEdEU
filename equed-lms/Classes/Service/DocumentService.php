<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Exception\InvalidFileTypeException;
use Equed\EquedLms\Domain\Service\DocumentServiceInterface;
use Equed\EquedLms\Service\SettingsService;

/**
 * Service to generate secure download and template URIs for documents.
 */
final class DocumentService implements DocumentServiceInterface
{
    private const ALLOWED_EXTENSIONS = ['pdf', 'jpg', 'jpeg', 'png', 'docx'];

    public function __construct(
        private readonly string $documentsBaseUri,
        private readonly string $templatesBaseUri,
        private readonly ?SettingsService $settingsService = null
    ) {
    }

    /**
     * Generate a download URI for a given file.
     *
     * @param string $fileName
     * @return string
     * @throws InvalidFileTypeException
     */
    public function generateDownloadLink(string $fileName): string
    {
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $this->getAllowedExtensions(), true)) {
            throw new InvalidFileTypeException(
                sprintf('File type "%s" is not permitted.', $extension)
            );
        }

        $safeName = basename($fileName);
        return rtrim($this->documentsBaseUri, '/') . '/' . $safeName;
    }

    /**
     * Get the template PDF URI for a given template name.
     *
     * @param string $templateName
     * @return string
     */
    public function getTemplatePath(string $templateName): string
    {
        $safeName = preg_replace('/[^a-zA-Z0-9_\-]/', '', $templateName);
        return rtrim($this->templatesBaseUri, '/') . '/' . $safeName . '.pdf';
    }

    /**
     * Returns allowed file extensions either from settings or the default list.
     *
     * @return string[]
     */
    private function getAllowedExtensions(): array
    {
        $custom = $this->settingsService?->get('allowedDocumentExtensions');
        if (is_string($custom)) {
            $custom = array_filter(array_map('trim', explode(',', $custom)));
        }
        if (is_array($custom) && $custom !== []) {
            return array_map('strtolower', $custom);
        }

        return self::ALLOWED_EXTENSIONS;
    }
}
