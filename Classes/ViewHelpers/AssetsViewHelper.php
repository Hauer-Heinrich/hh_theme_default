<?php
namespace HauerHeinrich\HhThemeDefault\ViewHelpers;

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
 *   xmlns:hh="http://typo3.org/ns/VENDOR/NAMESPACE/ViewHelpers"
 *   data-namespace-typo3-fluid="true">
 *
 *  EXAMPLE:
 * <hh:assets src="myPathToCss/myCss.css" order="1" />
 * or
 * <hh:assets src="myPathToJs/myJs.js" order="1" type="js" />
 */

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class AssetsViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        $this->registerArguments([
            ['order', 'string', 'Ordering int', true],
            ['src', 'string', 'Path to css or js file', true],
            ['current', 'bool', 'Set current extension folder for source', false, true]
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

        if($arguments['current'] === true) {
            // Get current ExtKey from templatePath
            $templatePaths = array_reverse($renderingContext->getTemplatePaths()->getTemplateRootPaths());
            $extKey = '';
            foreach ($templatePaths as $key => $value) {
                if(!empty($value)) {
                    $extKey = explode('/', explode('/ext/', $value)[1])[0];
                    break;
                }
            }

            if(self::endsWith($arguments['src'], '.js')) {
                $type = 'js';
                $path = 'EXT:'.$extKey.'/Resources/Public/JavaScript/'.trim($arguments['src']);
            } else {
                $path = 'EXT:'.$extKey.'/Resources/Public/Css/'.trim($arguments['src']);
            }
        } else {
            if(self::endsWith($arguments['src'], '.js')) {
                $type = 'js';
            }

            $path = trim($arguments['src']);
        }

        if (is_numeric($arguments['order'])) {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hh_theme_default']['assets'][$type][$arguments['order']] = $path;
        } else {
            $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hh_theme_default']['assets']['custom'][$type][$arguments['order']] = $path;
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
