<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Exception\InvalidFileTypeException;

interface DocumentServiceInterface
{
    /**
     * Generate a download URI for a given file.
     *
     * @param string $fileName
     * @return string
     * @throws InvalidFileTypeException
     */
    public function generateDownloadLink(string $fileName): string;

    /**
     * Get the template PDF URI for a given template name.
     */
    public function getTemplatePath(string $templateName): string;
}
