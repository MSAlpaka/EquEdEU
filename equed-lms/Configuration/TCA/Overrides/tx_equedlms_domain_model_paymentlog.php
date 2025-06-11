<?php

declare(strict_types=1);
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(function () {
    ExtensionManagementUtility::addTCAcolumns('tx_equedlms_domain_model_paymentlog', [
        'user' => [
            'label' => 'User',
            'config' => [
                'type' => 'group',
                'internal_type' => 'db',
                'allowed' => 'fe_users',
                'maxitems' => 1,
            ],
        ],
        'amount' => [
            'label' => 'Amount (€)',
            'config' => [
                'type' => 'number',
                'default' => 0.00,
            ],
        ],
        'payment_method' => [
            'label' => 'Payment Method',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['PayPal', 'paypal'],
                    ['Credit Card', 'creditcard'],
                    ['Bank Transfer', 'bank'],
                    ['Other', 'other'],
                ],
            ],
        ],
        'transaction_id' => [
            'label' => 'Transaction ID',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
        'status' => [
            'label' => 'Status',
            'config' => [
                'type' => 'select',
                'items' => [
                    ['Pending', 'pending'],
                    ['Completed', 'completed'],
                    ['Failed', 'failed'],
                    ['Refunded', 'refunded'],
                ],
            ],
        ],
        'uuid' => [
            'label' => 'UUID',
            'config' => [
                'type' => 'input',
                'eval' => 'unique,trim',
                'required' => true,
            ],
        ],
        'created_at' => [
            'label' => 'Created At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
        'updated_at' => [
            'label' => 'Updated At',
            'config' => [
                'type' => 'datetime',
            ],
        ],
    ]);

    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_equedlms_domain_model_paymentlog',
        '--div--;Payment,
        user, amount, payment_method, transaction_id, status,
        uuid, created_at, updated_at'
    );
})();
