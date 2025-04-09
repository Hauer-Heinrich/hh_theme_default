<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Core\Environment;

$extensionKey = '{{EXTENSION_NAMESPACE_ES6}}';

// Production / Live - default settings:
// Default, is overwritten by Stage and local development
$additionalConfigDefault = Environment::getPublicPath() . '/typo3conf/ext/'.$extensionKey.'/system/additional/production.php';
if (file_exists($additionalConfigDefault)) {
    require_once ($additionalConfigDefault);
}

switch (Environment::getContext()->__toString()) {
    case 'Development/Server': // Developement - Stage / Preview:
        $additionalConfig = Environment::getPublicPath() . '/typo3conf/ext/'.$extensionKey.'/system/additional/preview.php';
        break;

    case 'Development': // Developement / localhost:
        $additionalConfig = Environment::getPublicPath() . '/typo3conf/ext/'.$extensionKey.'/system/additional/development.php';
        break;
    default:
        $additionalConfig = '';
        break;
}

if (file_exists($additionalConfig)) {
    require_once ($additionalConfig);
}

// typo3_config directory contains configuration for e.g. database access,
// install tool password and configuration for system dependent settings.
$databaseCredentialsFile = Environment::getPublicPath() . '/../config/typo3_env_config.php';
if (file_exists($databaseCredentialsFile)) { require_once ($databaseCredentialsFile); }
