<?php

declare(strict_types=1);

namespace TCPDF { if (!class_exists(\TCPDF::class)) { class TCPDF { public function AddPage(){} public function SetFont($a,$b,$c){} public function Write($a,$b){} public function Ln(){} public function Output($d,$t){ return 'pdf'; } } } }
namespace ZipArchiveNS { if (!class_exists(\ZipArchive::class)) { class ZipArchive { public $files=[]; public function open($file,$flags){ $this->path=$file; return true; } public function addFile($file,$name){ $this->files[]=$name; } public function close(){} } } }

namespace Equed\EquedLms\Service { if (!interface_exists(FilesystemInterface::class)) { interface FilesystemInterface { public function exists(string $p): bool; public function mkdir(string|array $p, int $m=0777): void; public function dumpFile(string $p, string $c): void; public function remove(string|array $p): void; } } if (!class_exists(DummyFilesystem::class)) { class DummyFilesystem implements FilesystemInterface { public array $dumped=[]; public array $mkdir=[]; public array $removed=[]; public function exists(string $p): bool { return false; } public function mkdir(string|array $p, int $m=0777): void { $this->mkdir[]=$p; } public function dumpFile(string $p, string $c): void { $this->dumped[$p]=$c; } public function remove(string|array $p): void { $this->removed[]=$p; } } } }
namespace Psr\Log { if (!interface_exists(LoggerInterface::class)) { interface LoggerInterface { public function emergency($m,array $c=[]); public function alert($m,array $c=[]); public function critical($m,array $c=[]); public function error($m,array $c=[]); public function warning($m,array $c=[]); public function notice($m,array $c=[]); public function info($m,array $c=[]); public function debug($m,array $c=[]); } } }

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\TrainingRecordGeneratorService;
use Equed\EquedLms\Service\LogService;
use Equed\EquedLms\Domain\Service\LanguageServiceInterface;
use Equed\EquedLms\Tests\Traits\ProphecyTrait;
use PHPUnit\Framework\TestCase;
use Equed\EquedLms\Service\DummyFilesystem as Filesystem;
use TCPDF;
use ZipArchive;
use DateTimeImmutable;

class TrainingRecordGeneratorServiceTest extends TestCase
{
    use ProphecyTrait;
    public function testGeneratePdfWritesFile(): void
    {
        $fs = new Filesystem();
        $logger = $this->prophesize(\Psr\Log\LoggerInterface::class);
        $logService = new LogService($logger->reveal());
        $language = $this->prophesize(LanguageServiceInterface::class);
        $service = new TrainingRecordGeneratorService('/tmp', $language->reveal(), $logService, $fs, fn() => new TCPDF(), fn() => new ZipArchive());
        $path = $service->generatePdf(['course'=>'c','cert_number'=>'n1','issued_on'=>'2024']);
        $this->assertArrayHasKey($path, $fs->dumped);
    }

    public function testGenerateZipReturnsPath(): void
    {
        $fs = new Filesystem();
        $logger = $this->prophesize(\Psr\Log\LoggerInterface::class);
        $logService = new LogService($logger->reveal());
        $language = $this->prophesize(LanguageServiceInterface::class);
        $service = new TrainingRecordGeneratorService('/tmp', $language->reveal(), $logService, $fs, fn() => new TCPDF(), fn() => new ZipArchive());
        $path = $service->generateZip(['course'=>'c','cert_number'=>'n2','issued_on'=>'2024']);
        $this->assertStringEndsWith('.zip', $path);
        $this->assertContains('/tmp/n2.pdf', $fs->removed);
    }

    public function testFactoriesAreInvoked(): void
    {
        $fs = new Filesystem();
        $pdfCalled = false;
        $zipCalled = false;
        $logger = $this->prophesize(\Psr\Log\LoggerInterface::class);
        $logService = new LogService($logger->reveal());
        $language = $this->prophesize(LanguageServiceInterface::class);
        $service = new TrainingRecordGeneratorService(
            '/tmp',
            $language->reveal(),
            $logService,
            $fs,
            function () use (&$pdfCalled) { $pdfCalled = true; return new TCPDF(); },
            function () use (&$zipCalled) { $zipCalled = true; return new ZipArchive(); }
        );

        $pdfPath = $service->generatePdf(['course'=>'c','cert_number'=>'n3','issued_on'=>'2024']);
        $zipPath = $service->generateZip(['course'=>'c','cert_number'=>'n4','issued_on'=>'2024']);

        $this->assertTrue($pdfCalled);
        $this->assertTrue($zipCalled);
        $this->assertStringEndsWith('.pdf', $pdfPath);
        $this->assertStringEndsWith('.zip', $zipPath);
        $this->assertContains('/tmp/n4.pdf', $fs->removed);
    }

    public function testCreateCertificateData(): void
    {
        $record = new class {
            public function getCertificateNumber() { return 'ABC'; }
            public function getCompletionDate() { return new DateTimeImmutable('2024-01-02'); }
            public function getCourseInstance() {
                return new class {
                    public function getCourseProgram() {
                        return new class {
                            public function getTitle() { return 'Prog'; }
                        };
                    }
                };
            }
        };

        $logger = $this->prophesize(\Psr\Log\LoggerInterface::class);
        $logService = new LogService($logger->reveal());
        $language = $this->prophesize(LanguageServiceInterface::class);
        $service = new TrainingRecordGeneratorService('/tmp', $language->reveal(), $logService, new Filesystem(), fn() => new TCPDF(), fn() => new ZipArchive());
        $data = $service->createCertificateData($record);

        $this->assertSame([
            'cert_number' => 'ABC',
            'course' => 'Prog',
            'issued_on' => '2024-01-02',
        ], $data);
    }
}
