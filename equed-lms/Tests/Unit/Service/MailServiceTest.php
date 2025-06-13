<?php

declare(strict_types=1);

namespace TYPO3\CMS\Core\Mail {
    if (!class_exists(MailMessage::class)) {
        class MailMessage
        {
            public string $to = '';
            public string $subject = '';
            public string $body = '';
            public string $from = '';
            public bool $sent = false;

            public function setTo(string $to): self { $this->to = $to; return $this; }
            public function setSubject(string $subject): self { $this->subject = $subject; return $this; }
            public function setBody(string $body, string $type = 'text/plain'): self { $this->body = $body; return $this; }
            public function setFrom(string $from): self { $this->from = $from; return $this; }
            public function attachFromPath(string $path): void {}
            public function send(): void { $this->sent = true; }
        }
    }
}

namespace Equed\EquedLms\Service\Email {
    if (!interface_exists(MailMessageFactoryInterface::class)) {
        interface MailMessageFactoryInterface
        {
            public function create(): \TYPO3\CMS\Core\Mail\MailMessage;
        }
    }
}

namespace Equed\EquedLms\Tests\Unit\Service {

use Equed\EquedLms\Service\Email\MailMessageFactoryInterface;
use Equed\EquedLms\Service\Email\MailService;
use Equed\EquedLms\Service\GptTranslationServiceInterface;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Core\Mail\MailMessage;

class DummyFactory implements MailMessageFactoryInterface
{
    public ?MailMessage $lastMail = null;
    public function create(): MailMessage
    {
        return $this->lastMail = new MailMessage();
    }
}

class DummyTranslator implements GptTranslationServiceInterface
{
    public array $calls = [];
    public function __construct(private array $responses) {}
    public function isEnabled(): bool { return true; }
    public function translate(string $key, array $arguments = [], ?string $extension = null): ?string
    {
        $this->calls[] = [$key, $arguments, $extension];
        return $this->responses[$key] ?? null;
    }
}

class MailServiceTest extends TestCase
{
    public function testUsesExtensionKeyForTranslations(): void
    {
        $factory = new DummyFactory();
        $translator = new DummyTranslator([
            'email.certificate_issued.subject' => 'Sub',
            'email.certificate_issued.body' => 'Body',
            'email.default_from' => 'from@example.com',
        ]);

        $service = new MailService($factory, $translator);
        $service->sendCertificateIssuedMail('user@example.com', 'ABC');

        $this->assertSame('Sub', $factory->lastMail->subject);
        $this->assertSame('Body', $factory->lastMail->body);
        $this->assertSame('from@example.com', $factory->lastMail->from);
        $this->assertTrue($factory->lastMail->sent);

        foreach ($translator->calls as $call) {
            $this->assertSame('equed_lms', $call[2]);
        }
    }

    public function testFallbackWhenTranslationMissing(): void
    {
        $factory = new DummyFactory();
        $translator = new DummyTranslator([]);

        $service = new MailService($factory, $translator);
        $service->sendCertificateIssuedMail('user@example.com', '123');

        $this->assertSame('Your Certificate is Ready', $factory->lastMail->subject);
        $this->assertSame('Your certificate 123 has been issued. Thank you!', $factory->lastMail->body);
        $this->assertSame('noreply@equed.eu', $factory->lastMail->from);
    }
}

}
