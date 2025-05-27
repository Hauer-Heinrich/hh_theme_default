<?php
if (!defined('TYPO3')) {
    die('Access denied.');
}

use \TYPO3\CMS\Core\Log\LogLevel;
use \TYPO3\CMS\Core\Log\Writer\FileWriter;

// for env:TYPO3_CONTEXT = Production (which is the default) only!
$customChanges = [
    'BE' => [
        'lockSSL' => 1,
        'compressionLevel' => '0',
        'versionNumberInFilename' => 0,
        'RTE_imageStorageDir' => 'fileadmin/uploads_rte/',
        'lockIP' => 4, // DSGVO / GDPR,
        'lockIPv6' => 8,
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2idPasswordHash', // BcryptPasswordHash
            'options' => [],
        ],
        'requireMfa' => 3,
    ],
    'FE' => [
        'compressionLevel' => '0',
        'noPHPscriptInclude' => '1',
        'disableNoCacheParameter' => 0,
        'hidePagesIfNotTranslatedByDefault' => 1,
        'passwordHashing' => [
            'className' => 'TYPO3\\CMS\\Core\\Crypto\\PasswordHashing\\Argon2idPasswordHash', // BcryptPasswordHash
            'options' => [],
        ]
    ],
    'HTTP' => [
        'verify' => 1,
    ],
    'LOG' => [
        'TYPO3' => [
            'CMS' => [
                'deprecations' => [
                    'writerConfiguration' => [
                        'notice' => [
                            'TYPO3\CMS\Core\Log\Writer\FileWriter' => [
                                'disabled' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
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
                ],
            ],
        ],

        'TYPO3' => [
            'CMS' => [
                'deprecations' => [
                    'writerConfiguration' => [
                        'notice' => [
                            'TYPO3\CMS\Core\Log\Writer\FileWriter' => [
                                'disabled' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'GFX' => [
        'imagefile_ext' => 'pdf,png,jpg,jpeg,svg,webp',
    ],
    'SYS' => [
        'displayErrors' => 0,
        'errorHandlerErrors' => 6485,
        'cookieSecure' => 1,
        'UTF8filesystem' => 1,
        'clearCacheSystem' => 1,
        'enableDeprecationLog' => 0,
        'phpTimeZone' => 'Europe/Berlin',
        'systemLocale' => 'de_DE.utf8',
        'ipAnonymization' => '2',
        'belogErrorReporting' => 6485,
        'mediafile_ext' => 'gif,jpg,jpeg,png,webp,pdf,svg,mp3,mp4,webm,youtube,vimeo',
        'defaultScheme' => 'https',
        // cookieDomain e. g. 'cookieDomain' => '/(www\.)?(domainA|domainB)\.?(TLD)$/',
        'cookieDomain' => '/www\.(hh-theme-default\.hauer-heinrich)\.de$/',
        'trustedHostsPattern' => 'www\.hh-theme-default\.hauer-heinrich.de',
    ],
    'EXTENSIONS' => [
        'backend' => [
            'backendFavicon' => '',
            'backendLogo' => '',
            'loginFootnote' => 'www.hauer-heinrich.de',
            'loginHighlightColor' => '',
            'loginLogo' => '',
            'loginLogoAlt' => 'Shows the logo from: .',
        ],
        'news' => [
            'manualSorting' => '1',
            'showAdministrationModule' => '0',
        ],
        'hh_video_extender' => [
            'config' => [
                'typoScript' => 0
            ],
        ],
    ],
];
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
