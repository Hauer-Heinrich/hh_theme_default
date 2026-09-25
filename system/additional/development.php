<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\FileWriter;

// for env:TYPO3_CONTEXT = Development only!
// Overwrites previously set settings!
$customDevelopmentChanges = [
    'BE' => [
        'lockSSL' => 0,
        'versionNumberInFilename' => 0,
        'debug' => 1,
        'requireMfa' => 0,
    ],
    'FE' => [
        'debug' => 1,
        'noPHPscriptInclude' => 1,
        'disableNoCacheParameter' => 0
    ],
    'HTTP' => [
        'verify' => 0,
    ],
    'LOG' => [
        'TYPO3' => [
            'CMS' => [
                'deprecations' => [
                    'writerConfiguration' => [
                        'notice' => [
                            'TYPO3\CMS\Core\Log\Writer\FileWriter' => [
                                'disabled' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'writerConfiguration' => [
            LogLevel::NOTICE => [
                FileWriter::class => [
                    'disabled' => false,
                ],
            ],
            LogLevel::WARNING => [
                FileWriter::class => [
                    'disabled' => false,
                ],
            ],
            LogLevel::ERROR => [
                FileWriter::class => [
                    'disabled' => false,
                ],
            ]
        ],
    ],
    'SYS' => [
        'displayErrors' => 1,
        'errorHandlerErrors' => 32767,
        'cookieSecure' => 0,
        'sqlDebug' => 1,
        'enableDeprecationLog' => 'file',
        'belogErrorReporting' => 32767,
    ],
];
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customDevelopmentChanges);
