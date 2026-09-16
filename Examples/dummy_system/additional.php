<?php
defined('TYPO3') or die();

if (
    class_exists(\Composer\InstalledVersions::class)
    && \Composer\InstalledVersions::isInstalled('{{EXTENSION_VENDOR_ES6}}/{{EXTENSION_NAMESPACE_ES6}}')
) {
    $themeAdditional = \Composer\InstalledVersions::getInstallPath('{{EXTENSION_VENDOR_ES6}}/{{EXTENSION_NAMESPACE_ES6}}') . '/system/additional.php';
} else {
    $themeAdditional = \TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/typo3conf/ext/{{EXTENSION_KEY}}/system/additional.php';
}

if (file_exists($themeAdditional)) {
    require_once $themeAdditional;
}
