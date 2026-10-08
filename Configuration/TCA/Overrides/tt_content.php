<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

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
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.row_gap.label',
                'description' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.row_gap.description',
                'config' => [
                    'type' => 'number',
                    'format' => 'integer',
                    'range' => [
                        'lower' => 0,
                        'upper' => 10,
                    ],
                    'slider' => [
                        'step' => 1,
                    ],
                    'default' => 1,
                ],
            ],
            'column_gap' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.column_gap.label',
                'description' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.column_gap.description',
                'config' => [
                    'type' => 'number',
                    'format' => 'integer',
                    'range' => [
                        'lower' => 0,
                        'upper' => 10,
                    ],
                    'slider' => [
                        'step' => 1,
                    ],
                    'default' => 1,
                ],
            ],
            'gallery_row_gap' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.gallery_row_gap.label',
                'description' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.gallery_row_gap.description',
                'config' => [
                    'type' => 'number',
                    'format' => 'integer',
                    'range' => [
                        'lower' => 0,
                        'upper' => 10,
                    ],
                    'slider' => [
                        'step' => 1,
                    ],
                    'default' => 1,
                ],
            ],
            'gallery_column_gap' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.gallery_column_gap.label',
                'description' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.gallery_column_gap.description',
                'config' => [
                    'type' => 'number',
                    'format' => 'integer',
                    'range' => [
                        'lower' => 0,
                        'upper' => 10,
                    ],
                    'slider' => [
                        'step' => 1,
                    ],
                    'default' => 1,
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
            ],
            'filelink_download_btn' => [
                'exclude' => 1,
                'label' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.filelink_download_btn',
                'description' => 'LLL:EXT:'.$extensionKey.'/Resources/Private/Language/locallang_db.xlf:tt_content.filelink_download_btn.description',
                'config' => [
                    'type' => 'check',
                    'renderType' => 'checkboxLabeledToggle',
                    'items' => [
                        [
                            'label' => 'Download Button',
                            'labelChecked' => 'Enabled',
                            'labelUnchecked' => 'Disabled',
                        ],
                    ],
                ],
            ],
        ]
    );
    ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'gap',
        'row_gap, column_gap'
    );

    ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'gallery_gap',
        'gallery_row_gap, gallery_column_gap'
    );

    ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'uploadslayout',
        '--linebreak--, filelink_download, filelink_download_btn',
        'after:uploads_type'
    );

    ExtensionManagementUtility::addFieldsToPalette(
        'tt_content',
        'frames',
        '--linebreak--,background',
        ''
    );

    // ce-textmedia
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--palette--;;gap',
        'textmedia',
        'after:layout'
    );
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--palette--;;gallery_gap',
        'textmedia',
        'after:imagecols'
    );
    // ce-image
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--palette--;;gallery_gap',
        'image',
        'after:imagecols'
    );
}, 'hh_theme_default');
