<?php
defined('TYPO3') or die();

call_user_func(function(string $extensionKey) {

    $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds']['*,news_pi1']
        = 'FILE:EXT:hh_theme_default/Configuration/Flexforms/news/flexform_news_list.xml';

}, 'hh_theme_default');
