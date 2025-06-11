<?php declare(strict_types=1);

namespace Equed\EquedCore\Tests\Functional\TCA;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class TcaCountryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['typo3conf/ext/equed_core'];

    public function testAllFieldsAreConfigured(): void
    {
        $table = $GLOBALS['TCA']['tx_equedcore_domain_model_country'];
        $this->assertArrayHasKey('country_iso', $table['columns']);
        $this->assertArrayHasKey('name_en', $table['columns']);
    }
}
