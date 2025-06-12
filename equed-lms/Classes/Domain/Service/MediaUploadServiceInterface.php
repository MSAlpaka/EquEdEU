<?php

declare(strict_types=1);

namespace Equed\EquedLms\Domain\Service;

use Equed\EquedLms\Domain\Model\FrontendUser;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

interface MediaUploadServiceInterface
{
    /**
     * Handles an upload request and stores the file in the default storage.
     *
     * @param array $uploadedFile Superglobal-like $_FILES['file'] array
     * @param FrontendUser $user  Authenticated user
     * @return FileReference|null Stored file reference or null on error
     */
    public function handleUpload(array $uploadedFile, FrontendUser $user): ?FileReference;
}
