<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function() {
    $extensionKey = '{{EXTENSION_KEY}}';

    // make TypoScript selectable
    ExtensionManagementUtility::addStaticFile(
        $extensionKey,
        'Configuration/TypoScript',
        'Theme TS'
    );
});
