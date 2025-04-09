<?php
defined('TYPO3') or die();

use \TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

call_user_func(function(string $extensionKey) {
    // Add addRootLineFields for example slide in TypoScript
    $rootLineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
    if (trim($rootLineFields) != "") $rootLineFields .= ',';
    $rootLineFields .= 'backend_layout,header_logo,footer_col1,footer_col2,footer_col3,footer_logo,footer_links,';

    // Typo3 extension manager gearwheel icon (ext_conf_template.txt)
    $extensionConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][$extensionKey];
    $rtePresets = $extensionConfiguration['rtePresets'];
    $rtePresetHeader = $extensionConfiguration['rtePresetHeader'];

    // Register own rte ckeditor config which comes from lines above
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['rte_theme'] = $rtePresets;
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['rte_header'] = $rtePresetHeader;

    // Register "hhdefault" as global fluid namespace
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['hhdefault'] = ['HauerHeinrich\\HhThemeDefault\\ViewHelpers'];

    // Exclude Params from cacheHash
    // for example to get rid of params for canonical generation
    // utm_id : for facebook
    $cacheFeExcludedParameters = &$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'];
    if(!in_array('utm_id', $cacheFeExcludedParameters)) {
        array_push($cacheFeExcludedParameters, 'utm_id');
    }
}, 'hh_theme_default');
