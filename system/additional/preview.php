<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use \TYPO3\CMS\Core\Log\LogLevel;
use \TYPO3\CMS\Core\Log\Writer\FileWriter;

// for env:TYPO3_CONTEXT = Development/Server only!
// Overwrites previously set settings!
// typo3_config directory contains configuration for e.g. database access,
// install tool password and configuration for system dependent settings.
$customChanges = [
    'LOG' => [
        'writerConfiguration' => [
            LogLevel::NOTICE => [
                FileWriter::class => [
                    'disabled' => true,
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
    ],
    'SYS' => [
        'displayErrors' => 1,
        'errorHandlerErrors' => 28672,
        'belogErrorReporting' => 28672,
        // cookieDomain e. g. 'cookieDomain' => '/(www\.)?(domainA|domainB)\.?(TLD)$/',
        'cookieDomain' => '/preview\.(hh-theme-default\.hauer-heinrich)\.de$/',
        'trustedHostsPattern' => 'preview\.hh-theme-default\.hauer-heinrich.de',
    ],
];
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
