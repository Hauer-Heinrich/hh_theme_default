<?php

defined('TYPO3') or die();

use TYPO3\CMS\Core\Core\Environment;

/*
 * Loads the theme's enforced configuration (values that must not be
 * changed via backend) plus context-specific overrides, followed by
 * machine-specific secrets stored outside the document root.
 */
(static function () {
    // Resolve the theme's base path once - works in Composer and legacy mode
    $themePath = null;
    if (
        class_exists(\Composer\InstalledVersions::class)
        && \Composer\InstalledVersions::isInstalled('{{EXTENSION_VENDOR_ES6}}/{{EXTENSION_NAMESPACE_ES6}}')
    ) {
        $themePath = \Composer\InstalledVersions::getInstallPath('{{EXTENSION_VENDOR_ES6}}/{{EXTENSION_NAMESPACE_ES6}}');
    } else {
        $legacyPath = Environment::getPublicPath() . '/typo3conf/ext/{{EXTENSION_KEY}}';
        if (is_dir($legacyPath)) {
            $themePath = $legacyPath;
        }
    }

    if ($themePath !== null) {
        // Production defaults first, context-specific overrides on top
        $configFiles = ['/system/additional/production.php'];

        $context = Environment::getContext();
        if ((string)$context === 'Development/Server') {
            // Stage / preview server
            $configFiles[] = '/system/additional/preview.php';
        } elseif ($context->isDevelopment()) {
            // Local development
            $configFiles[] = '/system/additional/development.php';
        }

        foreach ($configFiles as $configFile) {
            if (file_exists($themePath . $configFile)) {
                require $themePath . $configFile;
            }
        }
    }

    // Secrets: database credentials, install tool password, system-dependent
    // settings. Outside document root, not under version control. Loaded
    // last so its values always win.
    $secretsFile = Environment::getPublicPath() . '/../env/typo3_config.php';
    if (file_exists($secretsFile)) {
        require $secretsFile;
    }
})();
