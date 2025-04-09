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
 *  <hh:readFromFlexform flexform="{data.pi_flexform}">
 *  or
 *  <hh:readFromFlexform flexform="{data.pi_flexform}" field="header" sheet="sDEF" lang="lDEF" value="vDEF">
 */

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class ReadFromFlexformViewHelper extends AbstractViewHelper {
    public function initializeArguments() {
        $this->registerArgument('flexform', 'string', 'xml flexform', true);
        $this->registerArgument('field', 'string', 'xml flexform field', true);
        $this->registerArgument('sheet', 'string', 'like sDEF', false);
        $this->registerArgument('lang', 'string', 'like lDEF', false);
        $this->registerArgument('value', 'string', 'like vDEF', false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $flexformArray = GeneralUtility::xml2array(trim(preg_replace('/\s+/', ' ', $arguments['flexform'])));

        // https://api.typo3.org/typo3cms/8/html/class_t_y_p_o3_1_1_c_m_s_1_1_frontend_1_1_plugin_1_1_abstract_plugin.html#a28dce93387120cbe95320dca7e4842b7
        $fieldName = $arguments['field'];
        $sheet = $arguments['sheet'] ? $arguments['sheet'] : 'sDEF';
        $lang = $arguments['lang'] ? $arguments['lang'] : 'lDEF';
        $value = $arguments['value'] ? $arguments['value'] : 'vDEF';
        $result = self::pi_getFFvalue($flexformArray, $fieldName, $sheet, $lang, $value);
        return (string)$result;
    }

    /**
     * Return value from somewhere inside a FlexForm structure
     *
     * @param array $T3FlexForm_array FlexForm data
     * @param string $fieldName Field name to extract. Can be given like "test/el/2/test/el/field_templateObject" where each part will dig a level deeper in the FlexForm data.
     * @param string $sheet Sheet pointer, eg. "sDEF
     * @param string $lang Language pointer, eg. "lDEF
     * @param string $value Value pointer, eg. "vDEF
     * @return string|null The content.
     */
    public static function pi_getFFvalue($T3FlexForm_array, $fieldName, $sheet = 'sDEF', $lang = 'lDEF', $value = 'vDEF') {
        $sheetArray = $T3FlexForm_array['data'][$sheet][$lang] ?? '';
        if (is_array($sheetArray)) {
            return self::pi_getFFvalueFromSheetArray($sheetArray, explode('/', $fieldName), $value);
        }
        return null;
    }

    /**
     * Returns part of $sheetArray pointed to by the keys in $fieldNameArray
     *
     * @param array $sheetArray Multidimensional array, typically FlexForm contents
     * @param array $fieldNameArr Array where each value points to a key in the FlexForms content - the input array will have the value returned pointed to by these keys. All integer keys will not take their integer counterparts, but rather traverse the current position in the array and return element number X (whether this is right behavior is not settled yet...)
     * @param string $value Value for outermost key, typ. "vDEF" depending on language.
     * @return mixed The value, typ. string.
     * @internal
     * @see pi_getFFvalue()
     */
    public static function pi_getFFvalueFromSheetArray($sheetArray, $fieldNameArr, $value) {
        $tempArr = $sheetArray;
        foreach ($fieldNameArr as $k => $v) {
            if (\TYPO3\CMS\Core\Utility\MathUtility::canBeInterpretedAsInteger($v)) {
                if (is_array($tempArr)) {
                    $c = 0;
                    foreach ($tempArr as $values) {
                        if ($c == $v) {
                            $tempArr = $values;
                            break;
                        }
                        $c++;
                    }
                }
            } elseif (isset($tempArr[$v])) {
                $tempArr = $tempArr[$v];
            }
        }
        return $tempArr[$value] ?? '';
    }
}
