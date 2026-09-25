<?php
defined('TYPO3') or die();

if (
    class_exists(\Composer\InstalledVersions::class)
    && \Composer\InstalledVersions::isInstalled('hauerheinrich/hh-theme-default')
) {
    $themeAdditional = \Composer\InstalledVersions::getInstallPath('hauerheinrich/hh-theme-default') . '/system/additional.php';
} else {
    $themeAdditional = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3conf/ext/hh_theme_default/system/additional.php';
}

if (file_exists($themeAdditional)) {
    require_once $themeAdditional;
}
