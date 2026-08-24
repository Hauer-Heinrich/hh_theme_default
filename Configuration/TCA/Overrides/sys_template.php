<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function(string $extensionKey) {
    // make TypoScript selectable
    ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'Theme TS'
    );

    ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript/ExamplePages',
        'Theme Examples TypoScript'
    );
}, 'hh_theme_default');
