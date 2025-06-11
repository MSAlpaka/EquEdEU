<?php
declare(strict_types=1);

defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

(static function (): void {

    // CSH-Hilfe für Kursmodell
    ExtensionManagementUtility::addLLrefForTCAdescr(
        'tx_equedlms_domain_model_course',
        'EXT:equed_lms/Resources/Private/Language/locallang_csh_tx_equedlms_domain_model_course.xlf'
    );

    // CType: Glossary Viewer
    ExtensionManagementUtility::addPlugin(
        ['Glossar anzeigen (EquEd)', 'equed_glossary', 'content-plugin'],
        'CType',
        'equed_lms'
    );

    // CType: Kursanzeige
    ExtensionManagementUtility::addPlugin(
        ['Kursanzeige (EquEd)', 'equed_course', 'content-plugin'],
        'CType',
        'equed_lms'
    );

    // FlexForm für Kursanzeige
    ExtensionManagementUtility::addPiFlexFormValue(
        '*',
        'FILE:EXT:equed_lms/Configuration/FlexForms/CoursePlugin.xml',
        'equed_course'
    );
})();
