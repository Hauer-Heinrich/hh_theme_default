<?php
defined('TYPO3') or die();

call_user_func(function() {
    $extensionKey = 'hh_theme_default';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'Default Theme TS'
    );
});
