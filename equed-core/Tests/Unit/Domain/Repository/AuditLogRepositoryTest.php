<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Repository;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Domain\Repository\AuditLogRepository;
use Equed\EquedCore\Domain\Model\AuditLog;
use Equed\EquedCore\Cache\ArrayCache;
use Equed\EquedCore\Service\AuthorizationService;
use Equed\EquedCore\Domain\Service\AuthorizationServiceInterface;
use TYPO3\CMS\Core\Exception\AccessDeniedException;

class AuditLogRepositoryTest extends UnitTestCase
{
    protected AuditLogRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $cache = new ArrayCache();
        $auth = $this->createMock(AuthorizationServiceInterface::class);
        $this->repository = $this->getMockBuilder(AuditLogRepository::class)
            ->setConstructorArgs([$cache, $auth])
            ->onlyMethods(['findByIdentifier'])
            ->getMock();
    }

    public function testFindByUidReturnsEntity(): void
    {
        $log = new AuditLog();
        $log->setAction('test');
        $this->repository->method('findByIdentifier')->willReturn($log);
        $result = $this->repository->findByUid(1);
        $this->assertInstanceOf(AuditLog::class, $result);
    }

    public function testFindAllThrowsWhenUnauthorized(): void
    {
        $cache = new ArrayCache();
        $auth = new AuthorizationService([]);
        $repo = new AuditLogRepository($cache, $auth);

        $this->expectException(AccessDeniedException::class);
        $repo->findAll();
    }
}

/**
 * Mocked Services: AuthorizationServiceInterface
 */
