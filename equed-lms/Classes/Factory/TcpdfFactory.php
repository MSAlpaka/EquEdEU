<?php

declare(strict_types=1);

namespace Equed\EquedLms\Factory;

use TCPDF;

final class TcpdfFactory
{
    public function __invoke(): TCPDF
    {
        return new TCPDF();
    }
}
