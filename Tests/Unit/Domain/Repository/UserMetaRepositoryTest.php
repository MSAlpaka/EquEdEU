<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Repository;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Domain\Repository\UserMetaRepository;
use Equed\EquedCore\Domain\Model\UserMeta;
use Equed\EquedCore\Cache\ArrayCache;
use Equed\EquedCore\Service\AuthorizationService;

class UserMetaRepositoryTest extends UnitTestCase
{
    protected UserMetaRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $cache = new ArrayCache();
        $auth = $this->createMock(AuthorizationService::class);
        $this->repository = $this->getMockBuilder(UserMetaRepository::class)
            ->setConstructorArgs([$cache, $auth])
            ->onlyMethods(['findByIdentifier'])
            ->getMock();
    }

    public function testFindByUidReturnsEntity(): void
    {
        $meta = new UserMeta();
        $meta->setKey('foo');
        $this->repository->method('findByIdentifier')->willReturn($meta);
        $result = $this->repository->findByUid(1);
        $this->assertInstanceOf(UserMeta::class, $result);
    }
}

/*
 * Mocked Services: AuthorizationService
 */
