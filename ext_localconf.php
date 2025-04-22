<?php
defined('TYPO3') or die();

call_user_func(function(string $extensionKey) {
    // Typo3 extension manager gearwheel icon (ext_conf_template.txt)
    $extensionConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][$extensionKey];
    $rtePresets = $extensionConfiguration['rtePresets'];
    $rtePresetHeader = $extensionConfiguration['rtePresetHeader'];

    // Register own rte ckeditor config which comes from lines above
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['rte_theme'] = $rtePresets;
    $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['rte_header'] = $rtePresetHeader;

    // Register "hhdefault" as global fluid namespace
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['hhdefault'] = ['{{EXTENSION_VENDOR}}\\{{EXTENSION_NAMESPACE}}\\ViewHelpers'];

    // Exclude Params from cacheHash
    // for example to get rid of params for canonical generation
    // utm_id : for facebook
    $cacheFeExcludedParameters = &$GLOBALS['TYPO3_CONF_VARS']['FE']['cacheHash']['excludedParameters'];
    if(!in_array('utm_id', $cacheFeExcludedParameters)) {
        array_push($cacheFeExcludedParameters, 'utm_id');
    }

    // Include ExtensionsCustomConfigs
    $configFiles = glob(__DIR__ . '/ExtensionLocalconf/*.php');
    foreach ($configFiles as $file) {
        require_once $file;
    }
}, '{{EXTENSION_KEY}}');
