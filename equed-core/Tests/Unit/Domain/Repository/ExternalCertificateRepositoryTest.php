<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Repository;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Domain\Repository\ExternalCertificateRepository;
use Equed\EquedCore\Domain\Model\ExternalCertificate;
use Equed\EquedCore\Cache\ArrayCache;
use Equed\EquedCore\Service\AuthorizationService;

class ExternalCertificateRepositoryTest extends UnitTestCase
{
    protected ExternalCertificateRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $cache = new ArrayCache();
        $auth = $this->createMock(AuthorizationService::class);
        $this->repository = $this->getMockBuilder(ExternalCertificateRepository::class)
            ->setConstructorArgs([$cache, $auth])
            ->onlyMethods(['findByIdentifier'])
            ->getMock();
    }

    public function testFindByUidReturnsEntity(): void
    {
        $cert = new ExternalCertificate();
        $cert->setCertificateNumber('123');
        $this->repository->method('findByIdentifier')->willReturn($cert);
        $result = $this->repository->findByUid(1);
        $this->assertInstanceOf(ExternalCertificate::class, $result);
    }
}

/**
 * Mocked Services: AuthorizationService
 */
