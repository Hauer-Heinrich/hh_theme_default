<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\GeneralUtility;
use B13\Container\Tca\Registry;
use B13\Container\Tca\ContainerConfiguration;


call_user_func(function(string $extensionKey) {
    $containerRegistry = GeneralUtility::makeInstance(Registry::class);
    $containerRegistry->configureContainer(
        (
            new ContainerConfiguration(
                'grid-row-1--col-2', // CType
                '2 Column Container With Header', // label
                '', // description
                [
                    [
                        ['name' => 'left side', 'colPos' => 101],
                        ['name' => 'right side', 'colPos' => 102]
                    ]
                ] // grid configuration
            )
        )
        // set an optional icon configuration
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/container/col-2.svg')
        ->setSaveAndCloseInNewContentElementWizard(true)
    );
    // override default TCA settings (enable fields like "header", "subheader"...)
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'] = '
        --palette--;;general,
        --palette--;;headers,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
            --palette--;;frames,
            --palette--;;appearanceLinks,
            --palette--;;gap,
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
                '', // description
                [
                    [
                        ['name' => 'left side', 'colPos' => 101],
                        ['name' => 'center side', 'colPos' => 102],
                        ['name' => 'right side', 'colPos' => 103]
                    ]
                ] // grid configuration
            )
        )
        // set an optional icon configuration
        ->setIcon('EXT:'.$extensionKey.'/Resources/Public/Icons/container/col-3.svg')
        ->setSaveAndCloseInNewContentElementWizard(true)
    );
    // Copy the override TCA config from 'grid-row-1--col-2'
    $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-3']['showitem'] = $GLOBALS['TCA']['tt_content']['types']['grid-row-1--col-2']['showitem'];
}, '{{EXTENSION_KEY}}');
// EXT: container
