<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use \TYPO3\CMS\Core\Core\Environment;
use \TYPO3\CMS\Core\Log\LogLevel;
use \TYPO3\CMS\Core\Log\Writer\FileWriter;

// for env:TYPO3_CONTEXT = Production (which is the default) only!
// typo3_config directory contains configuration for e.g. database access,
// install tool password and configuration for system dependent settings.
$databaseCredentialsFile = Environment::getPublicPath() . '/../typo3_config/typo3_default.php';
if (file_exists($databaseCredentialsFile)) { require_once ($databaseCredentialsFile); }

$customChanges = [
    'BE' => [
        'lockSSL' => 1,
        'loginSecurityLevel' => 'normal',
        'compressionLevel' => '0',
        'versionNumberInFilename' => 0,
        'RTE_imageStorageDir' => 'fileadmin/uploads_rte/',
        'lockIP' => 4, // DSGVO / GDPR,
        // only if server has no argon2i
        // 'passwordHashing' => [
        //     'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
        //     'options' => [],
        // ]
    ],
    'FE' => [
        'loginSecurityLevel' => 'normal',
        'compressionLevel' => '0',
        'noPHPscriptInclude' => '1',
        'disableNoCacheParameter' => 0,
        'hidePagesIfNotTranslatedByDefault' => 1,
        // only if server has no argon2i
        // 'passwordHashing' => [
        //     'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
        //     'options' => [],
        // ]
    ],
    'HTTP' => [
        'verify' => 1,
    ],
    'LOG' => [
        'writerConfiguration' => [
            LogLevel::NOTICE => [
                FileWriter::class => [
                    'disabled' => true,
                ],
            ],
            LogLevel::WARNING => [
                FileWriter::class => [
                    'disabled' => true,
                ],
            ],

            LogLevel::ERROR => [
                FileWriter::class => [
                    'disabled' => false,
                    'logFile' => Environment::getVarPath() . '/log/typo3_errors.log'
                ],
            ]
        ],
    ],
    'GFX' => [
        'imagefile_ext' => 'pdf,png,jpg,jpeg,svg,webp'
    ],
    'SYS' => [
        'displayErrors' => 0,
        'errorHandlerErrors' => 20480,
        'cookieSecure' => 1,
        'UTF8filesystem' => 1,
        'clearCacheSystem' => 1,
        'enableDeprecationLog' => 0,
        'phpTimeZone' => 'Europe/Berlin',
        'systemLocale' => 'de_DE.UTF-8',
        'ipAnonymization' => '2',
    ],
];
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
