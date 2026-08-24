<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function(string $extensionKey) {
    // additional / extra config for: news
    ExtensionManagementUtility::registerPageTSConfigFile(
        $extensionKey,
        'Configuration/TsConfig/news-only.tsconfig',
        'Additional / extra config for: news'
    );
}, '{{EXTENSION_KEY}}');
