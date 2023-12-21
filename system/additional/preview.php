<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use \TYPO3\CMS\Core\Core\Environment;
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
    ],
];
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);


$databaseCredentialsFile = Environment::getPublicPath() . '/../typo3_config/typo3_{{EXTENSION_DOMAIN_NAME}}_preview.php';
if (file_exists($databaseCredentialsFile)) { require_once ($databaseCredentialsFile); }
