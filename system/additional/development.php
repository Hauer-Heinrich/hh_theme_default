<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use \TYPO3\CMS\Core\Log\LogLevel;
use \TYPO3\CMS\Core\Log\Writer\FileWriter;

// for env:TYPO3_CONTEXT = Development only!
// Overwrites previously set settings!
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
    'LOG' => [
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
        'errorHandlerErrors' => 32767,
        'cookieSecure' => 0,
        'sqlDebug' => 1,
        'enableDeprecationLog' => 'file',
        'belogErrorReporting' => 32767,
        // cookieDomain e. g. 'cookieDomain' => '/(www\.)?(domainA|domainB)\.?(TLD)$/',
        'cookieDomain' => '/www\.(hh-theme-default)\.de$/',
        'trustedHostsPattern' => 'www\.{{EXTENSION_DOMAIN_NAME}}\.localhost',
    ],
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
