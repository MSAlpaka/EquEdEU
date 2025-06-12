<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service;

use Equed\EquedLms\Exception\InvalidFileTypeException;
use Equed\EquedLms\Domain\Service\DocumentServiceInterface;

/**
 * Service to generate secure download and template URIs for documents.
 */
final class DocumentService implements DocumentServiceInterface
{
    /**
     * @var string[]
     */
    private array $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'docx'];

    private string $documentsBaseUri;
    private string $templatesBaseUri;

    public function __construct(string $documentsBaseUri, string $templatesBaseUri)
    {
        $this->documentsBaseUri = rtrim($documentsBaseUri, '/') . '/';
        $this->templatesBaseUri = rtrim($templatesBaseUri, '/') . '/';
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
        if (!in_array($extension, $this->allowedExtensions, true)) {
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
}
