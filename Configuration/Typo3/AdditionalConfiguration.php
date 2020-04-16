<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

// Production / Live:
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
        'pageNotFound_handling' => '404.html',
        'pageUnavailable_handling' => '503.html',
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
        'cookieSecure' => 1,
        'UTF8filesystem' => 1,
        'clearCacheSystem' => 1,
        'enableDeprecationLog' => 0,
        'phpTimeZone' => 'Europe/Berlin',
        'systemLocale' => 'de_DE.UTF-8',
        'ipAnonymization' => '2',
        'systemLogLevel' => '3',
   ]
];
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);

// Developement:
if(\TYPO3\CMS\Core\Core\Environment::getContext()->__toString() === 'Development') {
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
            'cookieSecure' => 0,
            'displayErrors' => 1,
            'sqlDebug' => 1,
            'systemLog' => 'error_log',
            'systemLogLevel' => '2',
            'enableDeprecationLog' => 'file',
        ]
    ];

    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customDevelopmentChanges);

    // Disable All Caches (in Development Mode)
    // disable Caching: https://usetypo3.com/did-you-know.html
    // (https://medium.com/typo3blog/disabling-typo3-caches-a137667848c9)
    foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $cacheName => $cacheConfiguration) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
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
