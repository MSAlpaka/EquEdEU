<?php

declare(strict_types=1);

namespace Equed\EquedLms\Event\Certificate;

use Equed\EquedLms\Domain\Model\CertificateDispatch;

/**
 * Event emitted when a certificate has been issued.
 */
final class CertificateIssuedEvent
{
    private readonly CertificateDispatch $certificate;

    /**
     * @param CertificateDispatch $certificate The dispatched certificate entity
     */
    public function __construct(CertificateDispatch $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * Returns the issued certificate.
     */
    public function getCertificate(): CertificateDispatch
    {
        return $this->certificate;
    }
}
// EOF
