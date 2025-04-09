<?php
defined('TYPO3') or die();

$themeDefaultAdditionalConfiguration = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3conf/ext/hh_theme_default/system/additional.php';
if (file_exists($themeDefaultAdditionalConfiguration)) { require_once ($themeDefaultAdditionalConfiguration); }
