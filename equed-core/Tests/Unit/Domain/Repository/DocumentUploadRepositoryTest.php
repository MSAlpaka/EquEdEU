<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Unit\Domain\Repository;

use TYPO3\TestingFramework\Core\Unit\UnitTestCase;
use Equed\EquedCore\Domain\Repository\DocumentUploadRepository;
use Equed\EquedCore\Domain\Model\DocumentUpload;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use Equed\EquedCore\Cache\ArrayCache;
use Equed\EquedCore\Service\AuthorizationService;
use TYPO3\CMS\Core\Exception\AccessDeniedException;

class DocumentUploadRepositoryTest extends UnitTestCase
{
    protected DocumentUploadRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $cache = new ArrayCache();
        $auth = $this->createMock(AuthorizationService::class);
        $this->repository = $this->getMockBuilder(DocumentUploadRepository::class)
            ->setConstructorArgs([$cache, $auth])
            ->onlyMethods(['findByIdentifier'])
            ->getMock();
    }

    public function testFindByUidReturnsEntity(): void
    {
        $upload = new DocumentUpload();
        $fileRef = new FileReference();
        $upload->setFileReference($fileRef);
        $this->repository->method('findByIdentifier')->willReturn($upload);
        $result = $this->repository->findByUid(1);
        $this->assertInstanceOf(DocumentUpload::class, $result);
    }

    public function testAddThrowsForNonInstructor(): void
    {
        $cache = new ArrayCache();
        $auth = new AuthorizationService([]);
        $repo = new DocumentUploadRepository($cache, $auth);

        $this->expectException(AccessDeniedException::class);
        $repo->add(new DocumentUpload());
    }

    public function testAddAllowedForInstructor(): void
    {
        $cache = new ArrayCache();
        $auth = new AuthorizationService(['instructor']);
        $repo = new DocumentUploadRepository($cache, $auth);

        $repo->add(new DocumentUpload());
        $this->assertTrue(true); // no exception was thrown
    }
}

/**
 * Mocked Services: AuthorizationService
 */
