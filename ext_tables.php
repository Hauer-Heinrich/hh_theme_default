<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Core\Environment;

call_user_func(function() {
    $extensionKey = 'hh_theme_default';

    // Backend modules to hide
    // example "sites" - module
    $typo3Context = Environment::getContext()->__toString();

    if($typo3Context === 'Production' || $typo3Context === 'Development/Server') {
        $backendModules = [
            'site' => [
                'configuration',
            ],
        ];

        foreach ($backendModules as $section => $modules) {
            $modulesToHide = GeneralUtility::trimExplode(',', $GLOBALS['TBE_MODULES'][$section]);
            $modulesToHide = array_diff($modulesToHide, $modules);
            $GLOBALS['TBE_MODULES'][$section] = implode(',', $modulesToHide);
        }
    }
});
