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

    private SettingsService|null $settingsService = null;

    private string $documentsBaseUri;
    private string $templatesBaseUri;

    public function __construct(string $documentsBaseUri, string $templatesBaseUri, ?SettingsService $settingsService = null)
    {
        $this->documentsBaseUri = rtrim($documentsBaseUri, '/') . '/';
        $this->templatesBaseUri = rtrim($templatesBaseUri, '/') . '/';
        $this->settingsService = $settingsService;
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
        return $this->documentsBaseUri . $safeName;
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
        return $this->templatesBaseUri . $safeName . '.pdf';
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
