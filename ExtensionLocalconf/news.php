<?php
defined('TYPO3') or die();

call_user_func(function(string $extensionKey) {
    // Extend News
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Domain/Model/News'][$extensionKey] = $extensionKey;
}, $extensionKey);
