<?php
defined('TYPO3') or die();

call_user_func(function () {
    // Überschreibt die richtextConfiguration für das description-Feld in tt_address
    $GLOBALS['TCA']['tt_address']['columns']['description']['config']['richtextConfiguration'] = 'rte_theme';

    // TCA für tt_address erweitern
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'tt_address',
        [
            'theme_skills' => [
                'exclude' => 1,
                'label' => 'Skills',
                'config' => [
                    'type' => 'text',
                    'cols' => 48,
                    'rows' => 2,
                    'enableRichtext' => false,
                ]
            ]
        ]
    );

    // Das Feld in das Backend-Formular integrieren
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
        'tt_address',
        'theme_skills',
        '',
        'after:position' // optional: Position im Formular
    );
});
