<?php

declare(strict_types=1);

namespace Equed\EquedLms\Tests\Functional\Controller;

use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Extbase\Mvc\Web\FrontendRequestHandler;

class UserCourseRecordControllerTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = [
        'typo3conf/ext/equed-lms',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->importDataSet(__DIR__ . '/../Fixtures/tx_equedlms_domain_model_usercourserecord.xml');
    }

    /**
     * @test
     */
    public function showActionReturnsUserCourseRecord(): void
    {
        $GLOBALS['TSFE'] = $this->setUpFrontendRootPage(1, [
            'EXT:equed-lms/Configuration/TypoScript/setup.typoscript',
        ]);

        $request = new ServerRequest(
            '/index.php?id=1',
            'GET',
            null,
            [
                'tx_equedlms_usercourserecord[controller]' => 'UserCourseRecord',
                'tx_equedlms_usercourserecord[action]' => 'show',
                'tx_equedlms_usercourserecord[usercourserecord]' => '1'
            ]
        );

        $response = GeneralUtility::makeInstance(FrontendRequestHandler::class)->handleRequest($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertStringContainsString('Course Record #1', (string)$response->getBody());
    }
}
