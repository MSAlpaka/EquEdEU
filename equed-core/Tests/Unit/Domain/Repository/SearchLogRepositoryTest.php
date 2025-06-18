<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Repository;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Domain\Repository\SearchLogRepository;
use Equed\EquedCore\Domain\Model\SearchLog;
use Equed\EquedCore\Cache\ArrayCache;
use Equed\EquedCore\Service\AuthorizationService;
use Equed\EquedCore\Domain\Service\AuthorizationServiceInterface;

class SearchLogRepositoryTest extends UnitTestCase
{
    protected SearchLogRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $cache = new ArrayCache();
        $auth = $this->createMock(AuthorizationServiceInterface::class);
        $this->repository = $this->getMockBuilder(SearchLogRepository::class)
            ->setConstructorArgs([$cache, $auth])
            ->onlyMethods(['findByIdentifier'])
            ->getMock();
    }

    public function testFindByUidReturnsEntity(): void
    {
        $log = new SearchLog();
        $log->setSearchTerm('foo');
        $this->repository->method('findByIdentifier')->willReturn($log);
        $result = $this->repository->findByUid(1);
        $this->assertInstanceOf(SearchLog::class, $result);
    }
}

/**
 * Mocked Services: AuthorizationServiceInterface
 */
