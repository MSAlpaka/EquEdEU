<?php

declare(strict_types=1);

namespace TCPDF { if (!class_exists(\TCPDF::class)) { class TCPDF { public function AddPage(){} public function SetFont($a,$b,$c){} public function Write($a,$b){} public function Ln(){} public function Output($d,$t){ return 'pdf'; } } } }
namespace ZipArchiveNS { if (!class_exists(\ZipArchive::class)) { class ZipArchive { public $files=[]; public function open($file,$flags){ $this->path=$file; return true; } public function addFile($file,$name){ $this->files[]=$name; } public function close(){} } } }

namespace Symfony\Component\Filesystem { if (!class_exists(Filesystem::class)) { class Filesystem { public array $dumped=[]; public array $mkdir=[]; public function exists($p){return false;} public function mkdir($p,$m=0777){$this->mkdir[]=$p;} public function dumpFile($p,$c){$this->dumped[$p]=$c;} } class Exception { interface IOExceptionInterface {} } }

namespace Equed\EquedLms\Tests\Unit\Service;

use Equed\EquedLms\Service\TrainingRecordGeneratorService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use TCPDF;
use ZipArchive;

class TrainingRecordGeneratorServiceTest extends TestCase
{
    public function testGeneratePdfWritesFile(): void
    {
        $fs = new Filesystem();
        $service = new TrainingRecordGeneratorService('/tmp', $fs, fn() => new TCPDF(), fn() => new ZipArchive());
        $path = $service->generatePdf(['course'=>'c','cert_number'=>'n1','issued_on'=>'2024']);
        $this->assertArrayHasKey($path, $fs->dumped);
    }

    public function testGenerateZipReturnsPath(): void
    {
        $fs = new Filesystem();
        $service = new TrainingRecordGeneratorService('/tmp', $fs, fn() => new TCPDF(), fn() => new ZipArchive());
        $path = $service->generateZip(['course'=>'c','cert_number'=>'n2','issued_on'=>'2024']);
        $this->assertStringEndsWith('.zip', $path);
    }
}
