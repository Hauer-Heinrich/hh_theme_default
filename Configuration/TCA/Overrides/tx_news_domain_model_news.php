<?php
defined('TYPO3') or die();

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function(string $extensionKey) {
    $ll = 'LLL:EXT:news/Resources/Private/Language/locallang_db.xlf:';

    // Neuen Type im Select-Feld registrieren (TYPO3 13: assoziative Syntax!)
    $GLOBALS['TCA']['tx_news_domain_model_news']['columns']['type']['config']['items'][] = [
        'label' => 'News (Theme Default)',
        'value' => 100,
    ];

    // Feld-Anzeige für den neuen Type – am einfachsten vom Default-Type (0) kopieren
    $GLOBALS['TCA']['tx_news_domain_model_news']['types'][100] = $GLOBALS['TCA']['tx_news_domain_model_news']['types'][0];

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

    ExtensionManagementUtility::addTCAcolumns(
        'tx_news_domain_model_news',
        $fields
    );
    ExtensionManagementUtility::addToAllTCAtypes(
        'tx_news_domain_model_news',
        '
            custom_media,
            custom_media_2
        ',
        '100',
        'before:fal_media'
    );



    // $GLOBALS['TCA']['tx_news_domain_model_news']['types'][100]['showitem'] = '
    //     tx_extbase_type,
    //     --palette--;;paletteCore,title,--palette--;;paletteSlug,teaser,
    //         externalurl,
    //         --palette--;;paletteDate,
    //     --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.media,
    //         fal_media,
    //         fal_related_files,
    //     --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
    //         categories,
    //     --div--;' . $ll . 'tx_news_domain_model_news.tabs.relations,
    //         related,related_from,
    //         related_links,tags,
    //     --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.metadata,
    //         --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.editorial;paletteAuthor,
    //         --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.metatags;metatags,
    //         --palette--;' . $ll . 'tx_news_domain_model_news.palettes.alternativeTitles;alternativeTitles,
    //     --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
    //         --palette--;;paletteLanguage,
    //     --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
    //         --palette--;;paletteHidden,
    //         --palette--;;paletteAccess,
    //     --div--;' . $ll . 'notes,
    //         notes,
    //     --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.tabs.extended,
    // ';
}, 'hh_theme_default');
