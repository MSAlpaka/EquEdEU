<?php

declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(static function (): void {
    ExtensionManagementUtility::addTcaSelectItem(
        'tt_content',
        'CType',
        [
            'LLL:EXT:equed_lms/Resources/Private/Language/locallang_ttc.xlf:lmscontent_teaserbox',
            'lmscontent_teaserbox',
            'content-text',
        ],
        'textmedia',
        'after'
    );

    ArrayUtility::mergeRecursiveWithOverrule(
        $GLOBALS['TCA']['tt_content']['columns'],
        [
            'subheader' => [
                'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_ttc.xlf:subheader',
                'config' => [
                    'type' => 'input',
                    'size' => 50,
                    'eval' => 'trim',
                ],
            ],
            'link' => [
                'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_ttc.xlf:link',
                'config' => [
                    'type' => 'inputLink',
                    'renderType' => 'inputLink',
                    'softref' => 'typolink',
                ],
            ],
        ]
    );

    $GLOBALS['TCA']['tt_content']['types']['lmscontent_teaserbox'] = [
        'showitem' => '
            --palette--;;general,
            header, subheader,
            bodytext,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:media,
            image,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:links,
            header_link, link,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        ',
    ];
})();
// EOF
