<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function(string $extensionKey) {
    $fields = [
        'custom_media' => [
            'exclude' => 1,
            'label' => 'Banner',
            'config' => [
                'type' => 'file',
                'maxitems' => 10,
                'allowed' => 'common-image-types',
                'appearance' => [
                    'expandSingle' => true,
                    'collapseAll' => true,
                    'fileUploadAllowed' => false,
                    'fileByUrlAllowed' => false,
                ],
            ],
        ],
        'custom_media_2' => [
            'exclude' => 1,
            'label' => 'Image List View',
            'config' => [
                'type' => 'file',
                'maxitems' => 1,
                'allowed' => 'common-image-types',
                'appearance' => [
                    'expandSingle' => true,
                    'collapseAll' => true,
                    'fileUploadAllowed' => false,
                    'fileByUrlAllowed' => false,
                ],
            ],
        ],
    ];

    ExtensionManagementUtility::addTCAcolumns('tx_news_domain_model_news', $fields);
    ExtensionManagementUtility::addToAllTCAtypes('tx_news_domain_model_news', 'custom_media, custom_media_2', '', 'before:fal_media');
}, '{{EXTENSION_KEY}}');
