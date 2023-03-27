<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use \TYPO3\CMS\Core\Core\Environment;
use \TYPO3\CMS\Core\Log\LogLevel;
use \TYPO3\CMS\Core\Log\Writer\FileWriter;

// for env:TYPO3_CONTEXT = Development only!
// Overwrites previously set settings!
// typo3_config directory contains configuration for e.g. database access,
// install tool password and configuration for system dependent settings.
$databaseCredentialsFile = Environment::getPublicPath() . '/../typo3_config/typo3_default_local.php';
if (file_exists($databaseCredentialsFile)) { require_once ($databaseCredentialsFile); }

$customDevelopmentChanges = [
    'BE' => [
        'compressionLevel' => '0',
        'lockSSL' => 0,
        'versionNumberInFilename' => 0,
        'debug' => 1
    ],
    'FE' => [
        'compressionLevel' => '0',
        'debug' => 1,
        'noPHPscriptInclude' => 1,
        'disableNoCacheParameter' => 0
    ],
    'HTTP' => [
        'verify' => 0,
    ],
    'SYS' => [
        'displayErrors' => 1,
        'errorHandlerErrors' => 30466,
        'cookieSecure' => 0,
        'sqlDebug' => 1,
        'enableDeprecationLog' => 'file',
    ],
    'LOG' => [
        // TODO:
        // 'writerConfiguration' => [
        //     LogLevel::NOTICE => [
        //         FileWriter::class => [
        //             'disabled' => false,
        //         ],
        //     ],
        //     LogLevel::WARNING => [
        //         FileWriter::class => [
        //             'disabled' => false,
        //         ],
        //     ],

        //     LogLevel::ERROR => [
        //         FileWriter::class => [
        //             'disabled' => false,
        //             'logFile' => Environment::getVarPath() . '/log/typo3_errors.log'
        //         ],
        //     ]
        // ],
    ]
];
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customDevelopmentChanges);

// Disable All Caches (in Development Mode)
// disable Caching: https://usetypo3.com/did-you-know.html
// (https://medium.com/typo3blog/disabling-typo3-caches-a137667848c9)
// foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $cacheName => $cacheConfiguration) {
//     if($cacheName != 'runtime') { // TYPO3 >= 12
//         $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
//     }
// }
