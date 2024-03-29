<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \B13\Container\Tca\Registry;
use \B13\Container\Tca\ContainerConfiguration;

call_user_func(function() {
    $extensionKey = '{{EXTENSION_KEY}}';

    // START: Add custom header_size field
    ExtensionManagementUtility::addTCAcolumns('tt_content',
        [
            'header_size' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.header_size',
                'description' => '',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        ['Default', 'default',],
                        ['Medium', 'medium',],
                        ['Large', 'large',],
                    ],
                    'size' => 1,
                    'maxitems' => 1,
                ],
            ],
        ]
    );
    ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'header',
        'header_size',
        'after: header_layout'
    );
    ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'headers',
        'header_size',
        'after: header_layout'
    );
    // END: Add custom header_size field

    // Change header field to RTE
    $GLOBALS['TCA']['tt_content']['columns']['header']['config'] = [
        'type' => 'text',
        'eval' => 'trim',
        'max' => 255,
        'rows' => 1,
        'enableRichtext' => true,
        'richtextConfiguration' => 'rte_header',
    ];

    // Overwrite Flexform
    $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds']['ttaddress_listview,list']
        = 'FILE:EXT:{{EXTENSION_KEY}}/Configuration/Flexforms/ttAddress/List.xml';

    $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds']['*,news_pi1']
        = 'FILE:EXT:{{EXTENSION_KEY}}/Configuration/Flexforms/news/flexform_news_list.xml';

    // EXT: container
    $containerRegistry = GeneralUtility::makeInstance(Registry::class);
    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-row-1--col-2', // CType
                '2 Column Container With Header', // label
                '', // description
                [
                    // rows
                    [
                        // columns
                        ['name' => 'left side', 'colPos' => 201],
                        ['name' => 'right side', 'colPos' => 202]
                    ]
                ]
            )
        )
        // override default configurations
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/Container/col-2.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );
    // override default TCA settings (enable fields like "header", "subheader"...)
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'] = '
        --palette--;;general,
        --palette--;;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
            --palette--;;language,
        --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
            --palette--;;hidden,
            --palette--;;access';

    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-row-1--col-3', // CType
                '3 Column Container With Header', // label
                '',
                [
                    [
                        ['name' => 'left side', 'colPos' => 201],
                        ['name' => 'middle side', 'colPos' => 202],
                        ['name' => 'right side', 'colPos' => 203]
                    ]
                ]
            )
        )
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/Container/col-3.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-3']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'];

    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-row-1--col-4',
                '4 Column Container With Header',
                '',
                [
                    [
                        ['name' => 'left side', 'colPos' => 201],
                        ['name' => 'middle left side', 'colPos' => 202],
                        ['name' => 'middle right side', 'colPos' => 203],
                        ['name' => 'right side', 'colPos' => 204]
                    ]
                ]
            )
        )
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/Container/col-4.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-4']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'];

    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-row-1--col-2--66-33',
                '2 Column (66-33) Container With Header',
                '',
                [
                    [
                        ['name' => 'left side', 'colPos' => 201],
                        ['name' => 'right side', 'colPos' => 202]
                    ]
                ]
            )
        )
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/Container/col-66-33.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2--66-33']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'];

    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-row-1--col-2--33-66',
                '2 Column (33-66) Container With Header',
                '',
                [
                    [
                        ['name' => 'left side', 'colPos' => 201], // , 'colspan' => 2
                        ['name' => 'right side', 'colPos' => 202] // , 'colspan' => 1
                    ]
                ]
            )
        )
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/Container/col-33-66.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2--33-66']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'];

    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-row-1--col-2--75-25',
                '2 Column (75-25) Container With Header',
                '',
                [
                    [
                        ['name' => 'left side', 'colPos' => 201],
                        ['name' => 'right side', 'colPos' => 202]
                    ]
                ]
            )
        )
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/Container/col-75-25.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2--75-25']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'];

    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-row-1--col-2--25-75',
                '2 Column (25-75) Container With Header',
                '',
                [
                    [
                        ['name' => 'left side', 'colPos' => 201],
                        ['name' => 'right side', 'colPos' => 202]
                    ]
                ]
            )
        )
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/Container/col-25-75.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2--25-75']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'];
    // EXT: container end
});
