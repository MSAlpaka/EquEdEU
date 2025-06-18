<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Repository;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Domain\Repository\CountryRepository;
use Equed\EquedCore\Domain\Model\Country;
use Equed\EquedCore\Cache\ArrayCache;
use Equed\EquedCore\Service\AuthorizationService;
use Equed\EquedCore\Domain\Service\AuthorizationServiceInterface;

class CountryRepositoryTest extends UnitTestCase
{
    protected CountryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $cache = new ArrayCache();
        $auth = $this->createMock(AuthorizationServiceInterface::class);
        $this->repository = $this->getMockBuilder(CountryRepository::class)
            ->setConstructorArgs([$cache, $auth])
            ->onlyMethods(['findByIdentifier'])
            ->getMock();
    }

    public function testFindByUidReturnsEntity(): void
    {
        $country = new Country();
        $country->setCountryIso('DE');
        $this->repository->method('findByIdentifier')->willReturn($country);
        $result = $this->repository->findByUid(1);
        $this->assertInstanceOf(Country::class, $result);
    }
}

/**
 * Mocked Services: AuthorizationServiceInterface
 */
