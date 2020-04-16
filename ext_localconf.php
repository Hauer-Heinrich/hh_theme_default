<?php
defined('TYPO3_MODE') || die();

call_user_func(function() {
    $extensionKey = 'hh_theme_default';

    // Add addRootLineFields for example slide in TypoScript
    $rootLineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
    if (trim($rootLineFields) != "") $rootLineFields .= ',';
    $rootLineFields .= 'backend_layout';

    // register svg icons: identifier and filename
    $icons = [
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

    foreach ($icons as $identifier => $path) {
        $iconType = substr($path, -3);

        switch ($iconType) {
            case 'svg':
                $iconRegistry->registerIcon(
                    $identifier,
                    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                    ['source' => "EXT:{$extensionKey}/Resources/Public/Images/{$path}"]
                );
                break;

            default:
                # png
                $iconRegistry->registerIcon(
                    $identifier,
                    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
                    ['source' => "EXT:{$extensionKey}/Resources/Public/Images/{$path}"]
                );
                break;
        }
    };

    // Add UserTS config as default for all BE users
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:hh_theme_default/Configuration/TsConfig/User/0100_default.typoscript">');

    // Register "hhdefault" as global fluid namespace
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['hhdefault'] = ['HauerHeinrich\\HhThemeDefault\\ViewHelpers'];

    // System information toolbar
    \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class)
        ->connect(
            \TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem::class,
            'getSystemInformation',
            \HauerHeinrich\HhThemeDefault\Backend\ToolbarItem\SystemInformationToolbarItemGit::class,
            'addGitInformation'
        );

    // Register Hooks
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['usePageCache'][] =
        'HauerHeinrich\\HhThemeDefault\\Hooks\\AssetsHook';
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['contentPostProc-output'][] =
        'HauerHeinrich\\HhThemeDefault\\Hooks\\AssetsHook->usePageCache';

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
