<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

$customChanges = [
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8mb4',
                'tableoptions' => [
                    'charset' => 'utf8mb4',
                    'collate' => 'utf8mb4_unicode_ci',
               ],
                'driver' => 'mysqli',
                'dbname' => '[DatabaseName]',
                'host' => 'localhost',
                'password' => '[DatabasePassword]',
                'user' => '[DatabaseUserName]',
                'unix_socket' => '',
                'port' => '3306'
            ]
        ]
    ],
    'BE' => [
        // 'installToolPassword' => '' // must be in single quotes!
    ],
    'GFX' => [
        // Windows example (GraphicsMagick)
        // 'im_path' => 'C:\\Program Files\\GraphicsMagick-1.3.31-Q16\\',
        // 'processor_path' => 'C:\\Program Files\\GraphicsMagick-1.3.31-Q16\\'

        // Windows example (ImageMagick)
        // 'im_path' => 'C:\\Program Files\\ImageMagick-7.0.8-Q16\\',
        // 'processor_path' => 'C:\\Program Files\\ImageMagick-7.0.8-Q16\\',
        // 'processor_path_lzw' => 'C:\\Program Files\\ImageMagick-7.0.8-Q16\\'

        // OSX - MAMP example (ImageMagick)
        // 'im_path' => '/Applications/MAMP/Library/bin/',
        // 'processor_path' => '/Applications/MAMP/Library/bin/'
    ],
    'MAIL' => [
        'defaultMailFromAddress' => '',
        'transport' => 'smtp',
        'transport_sendmail_command' => '/usr/sbin/sendmail -t -i ',
        'transport_smtp_encrypt' => true, // https://docs.typo3.org/c/typo3/cms-core/master/en-us/Changelog/10.4.x/Important-91070-SMTPTransportOptionTransport_smtp_encryptChangedToBoolean.html
        'transport_smtp_password' => '',
        'transport_smtp_server' => '', // e. g. smtp.gmail.com:587
        'transport_smtp_username' => '',
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);
