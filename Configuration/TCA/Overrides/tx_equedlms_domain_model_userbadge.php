
<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_userbadge', [
        'user' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_user',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'badge_type' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:userbadge.badge_type',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Advanced Specialist', 'advanced_specialist'],
                    ['Custom Badge', 'custom'],
                    ['Legacy Award', 'legacy'],
                ],
                'default' => 'custom',
            ],
        ],
        'title' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
            ],
        ],
        'description' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.description',
            'config' => [
                'type' => 'text',
                'rows' => 3,
                'cols' => 60,
            ],
        ],
        'awarded_at' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.date',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'issuer' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:userbadge.issuer',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'is_public' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:userbadge.is_public',
            'config' => [
                'type' => 'check',
                'default' => 0,
            ],
        ],
        'visible_in_profile' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:userbadge.visible_in_profile',
            'config' => [
                'type' => 'check',
                'default' => 1,
            ],
        ],
        'source_data' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:userbadge.source_data',
            'config' => [
                'type' => 'text',
                'enableRichtext' => false,
            ],
        ],
        'image' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.image',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
            ],
        ],
        'badge_level' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:userbadge.badge_level',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['None', 'none'],
                    ['Bronze', 'bronze'],
                    ['Silber', 'silver'],
                    ['Gold', 'gold'],
                ],
                'default' => 'none',
            ],
        ],
        'expires_at' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:userbadge.expires_at',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'renewal_required' => [
            'label' => 'LLL:EXT:equed_lms/Resources/Private/Language/locallang_db.xlf:userbadge.renewal_required',
            'config' => [
                'type' => 'check',
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,unique,required',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_userbadge',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
        user, badge_type, title, description, awarded_at, issuer,
        is_public, visible_in_profile, source_data, image, badge_level,
        expires_at, renewal_required, uuid'
    );
})();
