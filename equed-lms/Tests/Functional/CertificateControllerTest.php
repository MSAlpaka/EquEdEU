<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Functional\Controller;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\FrontendRequestHandler;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequest;
use TYPO3\TestingFramework\Core\Functional\Framework\Frontend\InternalRequestContext;

class CertificateControllerTest extends FunctionalTestCase
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
    public function certificateShowActionReturnsValidResponse(): void
    {
        $request = (new InternalRequest('/index.php'))
            ->withQueryParameters([
                'tx_equedlms_certificate[controller]' => 'certificate',
                'tx_equedlms_certificate[action]' => 'show',
                'tx_equedlms_certificate[certificate]' => 1,
            ]);

        $response = $this->executeFrontendRequest($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Certificate #1', (string)$response->getBody());
    }

    protected function executeFrontendRequest(
        InternalRequest $request,
        ?InternalRequestContext $context = null,
        bool $followRedirects = false
    ): \Psr\Http\Message\ResponseInterface {
        $GLOBALS['TSFE'] = $this->setUpFrontendRootPage(1, [
            'EXT:equed-lms/Configuration/TypoScript/setup.typoscript',
        ]);

        $frontendRequestHandler = GeneralUtility::makeInstance(FrontendRequestHandler::class);
        return $frontendRequestHandler->handleRequest($request);
    }
}
