<?php
declare(strict_types=1);

namespace {
    if (!class_exists('Equed\\EquedLms\\Domain\\Model\\FrontendUser', false)) {
        class_alias(\stdClass::class, 'Equed\\EquedLms\\Domain\\Model\\FrontendUser');
    }
    if (!class_exists('Equed\\EquedLms\\Domain\\Model\\Notification', false)) {
        class Notification {
            public function __construct(
                private string $type,
                private ?string $titleKey,
                private ?string $customMessage,
                private \DateTimeImmutable $createdAt
            ) {}
            public function getType(): string { return $this->type; }
            public function getTitleKey(): ?string { return $this->titleKey; }
            public function getCustomMessage(): ?string { return $this->customMessage; }
            public function getCreatedAt(): \DateTimeImmutable { return $this->createdAt; }
        }
        class_alias(Notification::class, 'Equed\\EquedLms\\Domain\\Model\\Notification');
    }
}

namespace Equed\EquedLms\Tests\Unit\Service {

use DateTimeImmutable;
use Equed\EquedLms\Service\Dashboard\NotificationAggregator;
use Equed\EquedLms\Domain\Repository\NotificationRepositoryInterface;
use Equed\EquedLms\Domain\Model\Notification;
use PHPUnit\Framework\TestCase;

class NotificationAggregatorTest extends TestCase
{
    public function testAggregateReturnsStructuredData(): void
    {
        $user = new \stdClass();
        $note = new Notification('info', 'title', 'msg', new DateTimeImmutable('2024-01-01 10:00'));

        $repo = new class([$note]) implements NotificationRepositoryInterface {
            public function __construct(private array $notes) {}
            public function findUnreadByUser($user): array { return []; }
            public function findLatestByUser($user, int $limit = 5): array { return $this->notes; }
            public function findByUid(int $uid): ?Notification { return null; }
            public function add(Notification $notification): void {}
            public function createQuery(): \TYPO3\CMS\Extbase\Persistence\QueryInterface { throw new \RuntimeException('unused'); }
        };

        $agg = new NotificationAggregator($repo);

        $result = $agg->aggregate($user);

        $this->assertCount(1, $result);
        $this->assertSame('info', $result[0]['type']);
        $this->assertSame('title', $result[0]['titleKey']);
        $this->assertSame('msg', $result[0]['customMessage']);
        $this->assertSame('2024-01-01 10:00', $result[0]['date']);
    }
}
}
