<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function() {
    $extensionKey = 'hh_theme_default';

    // make PageTsConfig selectable
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/page.tsconfig',
        'Default Theme Page TS'
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
});
