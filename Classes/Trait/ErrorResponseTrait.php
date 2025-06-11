<?php

declare(strict_types=1);

namespace Equed\EquedLms\Trait;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Trait to create standardized JSON error responses with localization.
 */
trait ErrorResponseTrait
{
    /**
     * Returns a JSON error response with a localized message.
     *
     * @param string $key        Localization key
     * @param int    $statusCode HTTP status code
     * @param string $extensionKey Extension key for localization
     * @return ResponseInterface
     */
    public function errorResponse(
        string $key,
        int $statusCode = 400,
        string $extensionKey = 'equed_lms'
    ): ResponseInterface {
        $message = LocalizationUtility::translate($key, $extensionKey) ?? $key;

        return new JsonResponse(
            ['status' => 'error', 'message' => $message],
            $statusCode
        );
    }
}
// End of file
