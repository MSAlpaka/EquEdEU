<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Functional\Controller;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Extbase\Mvc\Web\FrontendRequestHandler;

class CertificateGenerateTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/equed-lms',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_equedlms_domain_model_certificate.xml');
    }

    /**
     * @test
     */
    public function generateActionReturnsPdfResponse(): void
    {
        $GLOBALS['TSFE'] = $this->setUpFrontendRootPage(1, [
            'EXT:equed-lms/Configuration/TypoScript/setup.typoscript',
        ]);

        $request = new ServerRequest(
            '/index.php?id=1',
            'GET',
            null,
            [
                'tx_equedlms_certificate[controller]' => 'Certificate',
                'tx_equedlms_certificate[action]' => 'generate',
                'tx_equedlms_certificate[certificate]' => '1'
            ]
        );

        $response = GeneralUtility::makeInstance(FrontendRequestHandler::class)->handleRequest($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/pdf', $response->getHeaderLine('Content-Type'));
    }
}
