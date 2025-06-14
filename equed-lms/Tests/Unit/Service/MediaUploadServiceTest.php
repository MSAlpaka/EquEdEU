<?php

declare(strict_types=1);

namespace TYPO3\CMS\Core\Resource {
    if (!class_exists(ResourceStorage::class)) {
        class ResourceStorage {
            public function addFile($tmp, $folder, $name) { return new class { public function getUid(){return 5;} }; }
            public function getRootLevelFolder() { return 'root'; }
        }
        class StorageRepository {
            public function __construct(private $storage) {}
            public function findDefaultStorage() { return $this->storage; }
        }
        class ResourceFactory {
            public function createFileReferenceObject(array $data) { return (object)$data; }
        }
    }
}

namespace TYPO3\CMS\Extbase\Domain\Model { if (!class_exists(FileReference::class)) { class FileReference { private $res; public function setOriginalResource($r){$this->res=$r;} public function setTitle(string $t){} public function setDescription(string $d){} public function getOriginalResource(){return $this->res;} } } }

namespace Psr\Log { if (!interface_exists(LoggerInterface::class)) { interface LoggerInterface { public function emergency($m,array$c=[]); public function alert($m,array$c=[]); public function critical($m,array$c=[]); public function error($m,array$c=[]); public function warning($m,array$c=[]); public function notice($m,array$c=[]); public function info($m,array$c=[]); public function debug($m,array$c=[]); } } }

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Domain\Model\FrontendUser;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Service\MediaUploadService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\ResourceStorage;
use TYPO3\CMS\Core\Resource\StorageRepository;
use Psr\Log\LoggerInterface;

class MediaUploadServiceTest extends TestCase
{
    use ProphecyTrait;

    public function testHandleUploadRejectsInvalidMime(): void
    {
        $storageRepo = new StorageRepository(new ResourceStorage());
        $factory = new ResourceFactory();
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->warning('Upload rejected due to MIME type', Argument::type('array'))->shouldBeCalled();
        $logService = new LogService($logger->reveal());

        $service = new MediaUploadService($storageRepo, $logService, $factory, 1024);

        $result = $service->handleUpload(['tmp_name'=>'t','name'=>'f','type'=>'text/plain'], new FrontendUser());
        $this->assertNull($result);
    }

    public function testHandleUploadReturnsFileReference(): void
    {
        $storage = new ResourceStorage();
        $storageRepo = new StorageRepository($storage);
        $factory = new ResourceFactory();
        $logger = $this->prophesize(LoggerInterface::class);
        $logService = new LogService($logger->reveal());

        $service = new MediaUploadService($storageRepo, $logService, $factory, 1024);

        $file = ['tmp_name'=>'tmp','name'=>'file.jpg','type'=>'image/jpeg'];
        $ref = $service->handleUpload($file, new FrontendUser());
        $this->assertNotNull($ref);
    }

    public function testHandleUploadRejectsTooLargeFile(): void
    {
        $storageRepo = new StorageRepository(new ResourceStorage());
        $factory = new ResourceFactory();
        $logger = $this->prophesize(LoggerInterface::class);
        $logger->warning('Upload rejected due to file size', Argument::type('array'))->shouldBeCalled();
        $logService = new LogService($logger->reveal());

        $service = new MediaUploadService($storageRepo, $logService, $factory, 1);

        $tmp = tempnam(sys_get_temp_dir(), 'u');
        file_put_contents($tmp, str_repeat('x', 2));
        $result = $service->handleUpload(['tmp_name'=>$tmp,'name'=>'file.jpg','type'=>'image/jpeg'], new FrontendUser());
        unlink($tmp);
        $this->assertNull($result);
    }
}
