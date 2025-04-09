<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function(string $extensionKey) {
    // make PageTsConfig selectable
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/page.tsconfig',
        'Theme Page TS'
    );

    // additional / extra config for: news
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/news-only.tsconfig',
        'Additional / extra config for: news'
    );

    // additional / extra config for: address
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/tt_address-only.tsconfig',
        'Additional / extra config for: address'
    );
}, {{EXTENSION_KEY}});





// Configure new fields:
$fields = [
    'header_logo' => [
        'label' => 'Logo',
        'config' => [
            'type' => 'file',
            'maxitems' => 1,
            'allowed' => 'common-image-types',
            'appearance' => [
                'expandSingle' => true,
                'collapseAll' => true,
                'fileUploadAllowed' => false,
                'fileByUrlAllowed' => false,
            ],
        ],
    ],
    'footer_col1' => [
        'exclude' => true,
        'label' => 'Footer col 1',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
            //TODO: 'richtextConfiguration' => 'minimal',
            'default' => '',
            'eval' => 'trim',
        ],
    ],
    'footer_col2' => [
        'exclude' => true,
        'label' => 'Footer col 2',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
            //TODO: 'richtextConfiguration' => 'minimal',
            'default' => '',
            'eval' => 'trim',
        ],
    ],
    'footer_col3' => [
        'exclude' => true,
        'label' => 'Footer col 3',
        'config' => [
            'type' => 'text',
            'enableRichtext' => true,
            //TODO: 'richtextConfiguration' => 'minimal',
            'default' => '',
            'eval' => 'trim',
        ],
    ],
    'footer_links' => [
        'exclude' => true,
        'label' => 'Footer Links',
        'config' => [
            'type' => 'group',
            'allowed' => 'pages',
            'size' => 2,
            'minitems' => 0,
            'maxitems' => 10,
            'suggestOptions' => [
                'default' => [
                    'additionalSearchFields' => 'nav_title, url',
                    'addWhere' => 'AND pages.doktype = 1',
                ],
            ],
        ],
    ],
    'footer_logo' => [
        'exclude' => true,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.images',
        'config' => [
            'type' => 'file',
            'allowed' => 'common-image-types',
            'appearance' => [
                'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                'showPossibleLocalizationRecords' => true,
                'expandSingle' => true,
                'collapseAll' => true,
                'fileUploadAllowed' => false,
                'fileByUrlAllowed' => false,
            ],
            'behaviour' => [
                'allowLanguageSynchronization' => true,
            ],
        ],
    ],
];

// Add new fields to pages:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $fields);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages', // Table name
    '--div--;Footer Content,--palette--;Footer Inhalt;footer_content', // Field list to add
    '1', // List of specific types to add the field list to. (If empty, all type entries are affected)
    'after:*' // Insert fields before (default) or after one, or replace a field
);

// // Make fields visible in the TCEforms:
// \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
//     'pages', // Table name
//     '--div--;Footer Content,
//         footer_col1,
//         footer_col2,
//         footer_col3,
//         footer_links,
//         footer_logo
//     '
// );

// Add the new palette:
$GLOBALS['TCA']['pages']['palettes']['footer_content'] = [
    'showitem' => '
        header_logo,
        --linebreak--,
        footer_col1,
        footer_col2,
        footer_col3,
        --linebreak--,
        footer_links,
        footer_logo
    '
];
