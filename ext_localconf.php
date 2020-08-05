<?php
defined('TYPO3_MODE') || die();

call_user_func(function() {
    $extensionKey = 'hh_theme_default';

    // Add addRootLineFields for example slide in TypoScript
    $rootLineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
    if (trim($rootLineFields) != "") $rootLineFields .= ',';
    $rootLineFields .= 'backend_layout';

    // Typo3 extension manager gearwheel icon (ext_conf_template.txt)
    $extensionConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][$extensionKey];
    $rtePresets = $extensionConfiguration['rtePresets'];

    // Register own rte ckeditor config which comes from lines above
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['rte_theme'] = $rtePresets;

    // register svg icons: identifier and filename
    $icons = [
        // BackendLayouts
        'hh_one_column' => 'BackendIcons/header-1col.png',
        'hh_navaside_left' => 'BackendIcons/header-sidenav-left.png',
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

    // after Install - Add AdditionalConfiguration.php if not exist
    /** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
    $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
    $signalSlotDispatcher->connect(
        \TYPO3\CMS\Extensionmanager\Utility\InstallUtility::class,
        'afterExtensionInstall',
        \HauerHeinrich\HhThemeDefault\EventListener\AfterExtensionInstall::class,
        'addAdditionalConfiguration'
    );
});
