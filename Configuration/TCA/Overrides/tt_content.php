<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \B13\Container\Tca\Registry;
use \B13\Container\Tca\ContainerConfiguration;

call_user_func(function() {
    $extensionKey = 'hh_theme_default';

    // Change header field to RTE
    $GLOBALS['TCA']['tt_content']['columns']['header']['config'] = [
        'type' => 'text',
        'eval' => 'trim',
        'max' => 255,
        'rows' => 1,
        'enableRichtext' => true,
        'richtextConfiguration' => 'rte_header',
    ];

    // EXT: container
    $containerRegistry = GeneralUtility::makeInstance(Registry::class);
    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-col-2', // CType
                '2 Column Container With Header', // label
                '', // description
                [
                    // [
                    //     ['name' => 'header', 'colPos' => 200, 'colspan' => 2, 'allowed' => ['CType' => 'header, textmedia']]
                    // ],
                    [
                        ['name' => 'left side', 'colPos' => 201],
                        ['name' => 'right side', 'colPos' => 202]
                    ]
                ]
            )
        )
        // override default configurations
        // ->setIcon('EXT:container_example/Resources/Public/Icons/b13-2cols-with-header-container.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );

    // override default settings
    $GLOBALS['TCA']['tt_content']['types']['grid-col-2']['showitem'] = '
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
                'grid-col-3', // CType
                '3 Column Container With Header', // label
                '', // description
                [
                    // [
                    //     ['name' => 'header', 'colPos' => 200, 'colspan' => 2, 'allowed' => ['CType' => 'header, textmedia']]
                    // ],
                    [
                        ['name' => 'left side', 'colPos' => 201],
                        ['name' => 'middle side', 'colPos' => 202],
                        ['name' => 'right side', 'colPos' => 203]
                    ]
                ]
            )
        )
        // override default configurations
        // ->setIcon('EXT:container_example/Resources/Public/Icons/b13-2cols-with-header-container.svg')
        ->setSaveAndCloseInNewContentElementWizard(false)
    );

    // override default settings
    $GLOBALS['TCA']['tt_content']['types']['grid-col-3']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['grid-col-2']['showitem'];
});
