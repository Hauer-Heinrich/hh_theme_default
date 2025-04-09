<?php
defined('TYPO3') or die();

$themeDefaultAdditionalConfiguration = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3conf/ext/{{EXTENSION_KEY}}/system/additional.php';
if (file_exists($themeDefaultAdditionalConfiguration)) { require_once ($themeDefaultAdditionalConfiguration); }
