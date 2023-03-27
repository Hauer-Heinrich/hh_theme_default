<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use \TYPO3\CMS\Core\Core\Environment;

// for env:TYPO3_CONTEXT = Development/Server only!
// Overwrites previously set settings!
// typo3_config directory contains configuration for e.g. database access,
// install tool password and configuration for system dependent settings.
$databaseCredentialsFile = Environment::getPublicPath() . '/../typo3_config/typo3_default_preview.php';
if (file_exists($databaseCredentialsFile)) { require_once ($databaseCredentialsFile); }
