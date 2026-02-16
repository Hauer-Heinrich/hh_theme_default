<?php
namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\ViewHelpers;

/***************************************************************
 * Copyright notice
 *
 * (c) 2020 Christian Hackl <hackl.chris@googlemail.com>
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
 *
 * Example
 * <html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
 *   xmlns:hhdefault="http://typo3.org/ns/VENDOR/NAMESPACE/ViewHelpers"
 *   data-namespace-typo3-fluid="true">
 *
 * Get FAL object of a content element e. g. from a EXT:gridelements child record
 * or if only attribute "id" is given then it looks for the id of the sys_file_reference table!
 * (in this case, multible ids are allowed as comma-separeted string e.g. "85,4")
 *
 *  EXAMPLE:
 * <hhdefault:extendFluidArray originalArray="settings" as="settings" additionalData="{myNewValue: 1}" />
 */

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ExtendFluidArrayViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        $this->registerArguments([
            ['originalArray', 'array', 'FLUID array', true],
            ['additionalData', 'array', 'New values (key:value) to add.', true],
            ['as', 'string', '', false, 'settings']
        ]);
    }

    /**
     * registerArguments
     *
     * @param Array $registers
     * @return void
     */
    function registerArguments(Array $registers) {
        foreach($registers as $registerKey => $registerVal) {
            $this->registerArgument(...$registerVal);
        }
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return void
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $as = $arguments['as'];
        $originalArray = $arguments['originalArray'];
        $additionalData = $arguments['additionalData'];
        $extendedArray = $originalArray;

        if(!empty($additionalData) && is_array($additionalData)) {
            foreach ($additionalData as $key => $value) {
                $extendedArray[$key] = $value;
            }
        }

        $templateVariableContainer = $renderingContext->getVariableProvider();
        $templateVariableContainer->add($as, $extendedArray);
        // $content = $renderChildrenClosure();
        // $templateVariableContainer->remove($as);
    }
}
