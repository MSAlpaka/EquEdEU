<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Unit\Schema;

use PHPUnit\Framework\TestCase;

class ModelYamlTcaConsistencyTest extends TestCase
{
    private string $rootDir;

    protected function setUp(): void
    {
        $this->rootDir = dirname(__DIR__, 3);
    }

    public function testYamlAndTcaNamesMatch(): void
    {
        $yamlDir = $this->rootDir . '/Configuration/Schema/Domain/Model';
        $tcaDir  = $this->rootDir . '/Configuration/TCA';

        $yamlNames = array_map('strtolower', array_map(static fn (string $p): string => pathinfo($p, PATHINFO_FILENAME), glob($yamlDir . '/*.yaml')));
        $tcaNames  = array_map('strtolower', array_map(static function (string $p): string {
            return str_replace('tx_equedlms_domain_model_', '', pathinfo($p, PATHINFO_FILENAME));
        }, glob($tcaDir . '/tx_equedlms_domain_model_*.php')));

        sort($yamlNames);
        sort($tcaNames);

        $this->assertSame($yamlNames, $tcaNames, 'YAML and TCA model names must match');
    }

    public function testModelsHaveYamlAndTca(): void
    {
        $modelDir = $this->rootDir . '/Classes/Domain/Model';
        $yamlDir  = $this->rootDir . '/Configuration/Schema/Domain/Model';
        $tcaDir   = $this->rootDir . '/Configuration/TCA';

        foreach (glob($modelDir . '/*.php') as $phpFile) {
            $base  = pathinfo($phpFile, PATHINFO_FILENAME);
            $lower = strtolower($base);

            $yamlFile = $this->findFileIgnoringCase($yamlDir, $base . '.yaml');
            $tcaFile  = $tcaDir . '/tx_equedlms_domain_model_' . $lower . '.php';

            if ($yamlFile !== null || file_exists($tcaFile)) {
                $this->assertFileExists($yamlFile ?? '', "Missing YAML for model $base");
                $this->assertFileExists($tcaFile, "Missing TCA for model $base");
            }
        }
    }

    private function findFileIgnoringCase(string $dir, string $filename): ?string
    {
        $candidate = $dir . '/' . $filename;
        if (file_exists($candidate)) {
            return $candidate;
        }
        foreach (glob($dir . '/*') as $file) {
            if (strcasecmp(basename($file), $filename) === 0) {
                return $file;
            }
        }
        return null;
    }
}
