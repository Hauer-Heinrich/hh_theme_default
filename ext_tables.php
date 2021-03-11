<?php
defined('TYPO3_MODE') || die();

call_user_func(function() {
    $extensionKey = 'hh_theme_default';
    // $extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey));
    // $className = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($extensionKey);

    // $pluginName = strtolower('PluginName');
    // $pluginSignature = $extensionName.'_'.$pluginName;

    // If BE view - User logged in at BE
    if (TYPO3_MODE === 'BE' || TYPO3_MODE === 'FE' && isset($GLOBALS['BE_USER'])) {
        // add CSS and JS in TYPO3-BE
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'][]
            = \HauerHeinrich\HhThemeDefault\Hooks\BackendControllerHook::class . '->addCss';

        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'][]
            = \HauerHeinrich\HhThemeDefault\Hooks\BackendControllerHook::class . '->addJavaScript';
    }

    // Backend CSS
    $GLOBALS['TBE_STYLES']['skins']['backend']['stylesheetDirectories']['theme'] = 'EXT:'.$extensionKey.'/Resources/Public/Css/Backend/';

    // Backend modules to hide
    // example "sites" - module
    $typo3Context = \TYPO3\CMS\Core\Core\Environment::getContext()->__toString();

    if($typo3Context === 'Production' || $typo3Context === 'Development/Server') {
        $backendModules = [
            'site' => [
                'configuration',
            ],
        ];

        foreach ($backendModules as $section => $modules) {
            $modulesToHide = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $GLOBALS['TBE_MODULES'][$section]);
            $modulesToHide = array_diff($modulesToHide, $modules);
            $GLOBALS['TBE_MODULES'][$section] = implode(',', $modulesToHide);
        }
    }
});
