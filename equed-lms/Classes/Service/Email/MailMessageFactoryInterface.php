<?php

declare(strict_types=1);

namespace Equed\EquedLms\Service\Email;

use TYPO3\CMS\Core\Mail\MailMessage;

interface MailMessageFactoryInterface
{
    public function create(): MailMessage;
}

