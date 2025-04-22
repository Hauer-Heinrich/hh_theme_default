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

    // additional / extra config for: tt_address
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/tt_address-only.tsconfig',
        'Additional / extra config for: address'
    );

    // additional / extra config for: fe_users / felogin
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/fe_users-only.tsconfig',
        'Additional / extra config for: FE users'
    );
}, '{{EXTENSION_KEY}}');





// Configure new fields:
$fields = [
    'header_logo' => [
        'label' => 'Main Logo',
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
    'footer_logo' => [
        'label' => 'Footer Logo',
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

    'footer_links1' => [
        'exclude' => true,
        'label' => 'Social Media',
        'config' => [
            'type' => 'group',
            'allowed' => 'pages',
            'size' => 1,
            'minitems' => 0,
            'maxitems' => 1,
            'suggestOptions' => [
                'default' => [
                    'additionalSearchFields' => 'nav_title, url',
                    'addWhere' => 'AND pages.doktype = 199',
                ],
            ],
        ],
    ],
    'footer_links2' => [
        'exclude' => true,
        'label' => 'About Us',
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
    'footer_links3' => [
        'exclude' => true,
        'label' => 'Our Projects',
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
    'footer_links4' => [
        'exclude' => true,
        'label' => 'Helpful Links',
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
    'footer_address' => [
        'exclude' => true,
        'label' => 'Address',
        'config' => [
            'type' => 'group',
            'allowed' => 'tt_address',
            'size' => 1,
            'minitems' => 0,
            'maxitems' => 1,
            'suggestOptions' => [
                'default' => [
                    'additionalSearchFields' => 'nav_title, url',
                    'addWhere' => 'AND pages.doktype = 254',
                ],
            ],
        ],
    ],
];

// Add new fields to pages:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $fields);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages', // Table name
    '--div--;Site Content,--palette--;Header Inhalt;header_content,--palette--;Footer Inhalt;footer_content', // Field list to add
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
$GLOBALS['TCA']['pages']['palettes']['header_content'] = [
    'showitem' => '
        header_logo,
    '
];
$GLOBALS['TCA']['pages']['palettes']['footer_content'] = [
    'showitem' => '
        --linebreak--,
        footer_logo,
        footer_col1,
        --linebreak--,
        footer_links1,
        footer_links2,
        footer_links3,
        footer_links4,
        --linebreak--,
        footer_address,
    '
];
