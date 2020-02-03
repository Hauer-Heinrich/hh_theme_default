<?php
defined('TYPO3_MODE') || die();

call_user_func(function() {
    $extensionKey = 'hh_theme_default';

    // Add addRootLineFields for example slide in TypoScript
    $rootLineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
    if (trim($rootLineFields) != "") $rootLineFields .= ',';
    $rootLineFields .= 'backend_layout';

    // register svg icons: identifier and filename
    $iconsPng = [
        // BackendLayouts
        'hh_one_column' => 'BackendIcons/header-1col.png',
        'hh_navaside_left' => 'BackendIcons/header-sidenav-left.png',

        // Gridelements
        'hh_grid_1_column' => 'gridelements/1_column.png',
        'hh_grid_2_column' => 'gridelements/2_column.png',
        'hh_grid_3_column' => 'gridelements/3_column.png',
        'hh_grid_4_column' => 'gridelements/4_column.png',
        'hh_grid_25-75_column' => 'gridelements/25-75.png',
        'hh_grid_33-66_column' => 'gridelements/33-66.png',
        'hh_grid_66-33_column' => 'gridelements/66-33.png',
        'hh_grid_75-25_column' => 'gridelements/75-25.png',
        'hh_grid_slider' => 'gridelements/slider.png',
        'hh_grid_tabs' => 'gridelements/tabs.png'
    ];

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        \TYPO3\CMS\Core\Imaging\IconRegistry::class
    );

    foreach ($iconsPng as $identifier => $path) {
        $iconRegistry->registerIcon(
            $identifier,
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => "EXT:{$extensionKey}/Resources/Public/Images/{$path}"]
        );
    };

    // Add UserTS config as default for all BE users
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:hh_theme_default/Configuration/TsConfig/User/0100_default.typoscript">');

    // Register "hhdefault" as global fluid namespace
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['hhdefault'] = ['HauerHeinrich\\HhThemeDefault\\ViewHelpers'];

    // Register Hooks
    if (TYPO3_MODE === 'FE') {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_pagerenderer.php']['render-preProcess'][$extensionKey] =
            HauerHeinrich\HhThemeDefault\Hooks\AssetsHook::class . '->addAssets';
    }

    // after Install - Add AdditionalConfiguration.php if not exist
    /** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $signalSlotDispatcher->connect(
        \TYPO3\CMS\Extensionmanager\Utility\InstallUtility::class,
        'afterExtensionInstall',
        HauerHeinrich\HhThemeDefault\Signals\AfterExtensionInstall::class,
        'addAdditionalConfiguration'
    );
});
