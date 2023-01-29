<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use \TYPO3\CMS\Core\Core\Environment;

// Production / Live - default settings:
// these settings will be overridden by preview and / or development settings, see below
$additionalConfig = Environment::getPublicPath() . '/typo3conf/ext/hh_theme_default/System/additional/production.php';
if (file_exists($additionalConfig)) { require_once ($additionalConfig); }

// Developement - Stage / Preview:
if(Environment::getContext()->__toString() === 'Development/Server') {
    $additionalConfigPreview = Environment::getPublicPath() . '/typo3conf/ext/hh_theme_default/System/additional/preview.php';
    if (file_exists($additionalConfigPreview)) { require_once ($additionalConfigPreview); }
}

// Developement:
if(Environment::getContext()->__toString() === 'Development') {
    $additionalConfigDevelopment = Environment::getPublicPath() . '/typo3conf/ext/hh_theme_default/System/additional/development.php';
    if (file_exists($additionalConfigDevelopment)) { require_once ($additionalConfigDevelopment); }
}

// Special for windows systems
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $customWindows = [
        'SYS' => [
            'systemLocale' => 'de-de',
        ]
    ];
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customWindows);
}
