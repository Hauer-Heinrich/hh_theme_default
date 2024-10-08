<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use \B13\Container\Tca\Registry;
use \B13\Container\Tca\ContainerConfiguration;

call_user_func(function(string $extensionKey) {
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


    // Add custom fields
    ExtensionManagementUtility::addTCAcolumns('tt_content',
        [
            'background' => [
                'exclude' => 1,
                'label' => 'Background',
                'description' => '',
                'config' => [
                    'type' => 'select',
                    'renderType' => 'selectSingle',
                    'items' => [
                        [
                            'label' => 'none',
                            'value' => 0,
                        ],
                    ],
                ]
            ],
            'row_gap' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.row_gap',
                'description' => '',
                'config' => [
                    'type' => 'number',
                    'format' => 'integer',
                    'range' => [
                        'lower' => 0,
                        'upper' => 10
                    ],
                    'slider' => [
                        'step' => 1
                    ],
                ],
            ],
            'column_gap' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.column_gap',
                'description' => '',
                'config' => [
                    'type' => 'number',
                    'format' => 'integer',
                    'range' => [
                        'lower' => 0,
                        'upper' => 10
                    ],
                    'slider' => [
                        'step' => 1
                    ],
                ],
            ],
            'filelink_download' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.filelink_download',
                'description' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.filelink_download.description',
                'config' => [
                    'type' => 'check',
                    'renderType' => 'checkboxLabeledToggle',
                    'items' => [
                        [
                            'label' => 'Download',
                            'labelChecked' => 'Enabled',
                            'labelUnchecked' => 'Disabled',
                        ],
                    ],
                ],
            ]
        ]
    );
    ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'gap',
        'row_gap, column_gap'
    );

    ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'uploads',
        'filelink_download',
        'after:target'
    );

    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        'background',
        '',
        'after:layout'
    );

    // ce-textmedia
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--palette--;;gap',
        'textmedia',
        'after:layout'
    );
    // ce-image
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--palette--;;gap',
        'image',
        'after:layout'
    );


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
}, '{{EXTENSION_KEY}}');
