<?php
defined('TYPO3') or die();

$themeDefaultAdditionalConfiguration = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3conf/ext/{{EXTENSION_NAMESPACE_ES6}}/system/additional.php';
if (file_exists($themeDefaultAdditionalConfiguration)) { require_once ($themeDefaultAdditionalConfiguration); }
