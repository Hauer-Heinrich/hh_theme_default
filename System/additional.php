<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

// Production / Live:
$databaseCredentialsFile = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/../typo3_config/typo3_domain.php';
if (file_exists($databaseCredentialsFile)) { require_once ($databaseCredentialsFile); }

// Default custom settings for all TYPO3 context's
$customChanges = [
    'BE' => [
        'lockSSL' => 1,
        'loginSecurityLevel' => 'normal',
        'compressionLevel' => '0',
        'versionNumberInFilename' => 0,
        'RTE_imageStorageDir' => 'fileadmin/uploads_rte/',
        'lockIP' => 4, // DSGVO / GDPR,
        // only if server has no argon2i
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
            'options' => [],
        ]
    ],
    'FE' => [
        'loginSecurityLevel' => 'normal',
        'compressionLevel' => '0',
        'noPHPscriptInclude' => '1',
        'disableNoCacheParameter' => 0,
        'hidePagesIfNotTranslatedByDefault' => 1,
        // only if server has no argon2i
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\BcryptPasswordHash',
            'options' => [],
        ]
    ],
    'HTTP' => [
        'verify' => 1,
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
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);

// Production only
if(\TYPO3\CMS\Core\Core\Environment::getContext()->__toString() === 'Production') {
    $customProductionChanges = [
        'LOG' => [
            'writerConfiguration' => [
                \TYPO3\CMS\Core\Log\LogLevel::NOTICE => [
                    \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                        'disabled' => true,
                    ],
                ],
                \TYPO3\CMS\Core\Log\LogLevel::WARNING => [
                    \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                        'disabled' => true,
                    ],
                ],

                \TYPO3\CMS\Core\Log\LogLevel::ERROR => [
                    \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                        'disabled' => false,
                        'logFile' => \TYPO3\CMS\Core\Core\Environment::getVarPath() . '/log/typo3_errors.log'
                    ],
                ]
            ],
        ]
    ];
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customProductionChanges);
}

// Developement - Stage / Preview:
if(\TYPO3\CMS\Core\Core\Environment::getContext()->__toString() === 'Development/Server') {
    $databaseCredentialsFile = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/../typo3_config/typo3_domain_preview.php';
    if (file_exists($databaseCredentialsFile)) { require_once ($databaseCredentialsFile); }
}

// Developement:
if(\TYPO3\CMS\Core\Core\Environment::getContext()->__toString() === 'Development') {
    $databaseCredentialsFile = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/../typo3_config/typo3_domain_local.php';
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
        'EXT' => [
            'extConf' => [
            ]
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
        ]
    ];

    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customDevelopmentChanges);

    // Disable All Caches (in Development Mode)
    // disable Caching: https://usetypo3.com/did-you-know.html
    // (https://medium.com/typo3blog/disabling-typo3-caches-a137667848c9)
    foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $cacheName => $cacheConfiguration) {
        if($cacheName != 'runtime') { // TYPO3 >= 12
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
        }
    }
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
