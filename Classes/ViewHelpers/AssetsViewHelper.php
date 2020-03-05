<?php
namespace HauerHeinrich\HhThemeDefault\ViewHelpers;

// TODO: eventuell Depricated ab TYPO3 10.3 - muss noch getestet werden!!!
// 2020-02-25 7e342e74de [FEATURE] Introduce AssetCollector (thanks to Benni Mack)

/***************************************************************
 * Copyright notice
 *
 * (c) 2018 Christian Hackl <hackl.chris@googlemail.com>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * Example
 * <html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
 *   xmlns:hhdefault="http://typo3.org/ns/VENDOR/NAMESPACE/ViewHelpers"
 *   data-namespace-typo3-fluid="true">
 *
 *  EXAMPLE:
 * <hhdefault:assets src="myPathToCss/myCss.css" order="1" />
 * or
 * <hhdefault:assets src="myPathToJs/myJs.js" order="1" type="js" />
 */

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class AssetsViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        $this->registerArguments([
            ['order', 'string', 'Ordering int or string / orders int"s and strings separately', false],
            ['src', 'string', 'Path to css or js file', true],
            ['extKey', 'string', 'Extensionkey e. g. vendor_my_ext_name', true],
            ['position', 'string', 'only js files - Position "head" or "footer" (default js is footer)', false, 'footer'],
            ['async', 'bool', 'only js files - Add attribute "async" (default is false)', false, false],
            ['defer', 'bool', 'only js files - Add attribute "defer" (default is true)', false, true]
            // TODO: add media attribute
        ]);
    }

    function registerArguments(Array $registers){
        foreach($registers as $registerKey => $registerVal){
            $this->registerArgument(...$registerVal);
        }
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $path = '';
        $type = 'css';

        if(self::endsWith($arguments['src'], '.js')) {
            $type = 'js';
            $path = 'EXT:'.$arguments['extKey'].'/Resources/Public/JavaScript/'.trim($arguments['src']);

        } else {
            $path = 'EXT:'.$arguments['extKey'].'/Resources/Public/Css/'.trim($arguments['src']);
        }

        if($arguments['order']) {
            $order = $arguments['order'];
        } else {
            $order = $arguments['src'];
        }

        $fileArray['path'] = $path;
        $fileArray['async'] = $arguments['async'];
        $fileArray['defer'] = $arguments['defer'];
        if ($arguments['position'] === 'head' || $arguments['position'] === 'footer') {
            $fileArray['position'] = $arguments['position'];
        } else {
            // TODO: return hint - debug output that not allowed string is given
        }

        if (is_numeric($arguments['order'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hh_theme_default']['assets'][$type][$order] = $fileArray;
        } else {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hh_theme_default']['assets']['custom'][$type][$order] = $fileArray;
        }
    }

    /**
     * endsWith - return true if string(haystack) ends with string(needle)
     *
     * @param string $haystack
     * @param string $needle
     * @return void
     */
    protected static function endsWith(string $haystack, string $needle): bool {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
