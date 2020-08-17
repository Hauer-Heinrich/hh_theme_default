<?php
namespace HauerHeinrich\HhThemeDefault\ViewHelpers;

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
 *   xmlns:hh="http://typo3.org/ns/VENDOR/NAMESPACE/ViewHelpers"
 *   data-namespace-typo3-fluid="true">
 *
 * Get FAL object of a content element e. g. from a EXT:gridelements child record
 *
 *  EXAMPLE:
 * <hh:fal table="tt_content" field="image" id="id_of_element" as="references" />
 */

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FalViewHelper extends AbstractViewHelper {

    public function initializeArguments() {
        $this->registerArguments([
            ['table', 'string', 'DB table', false, 'tt_content'],
            ['field', 'string', 'reference field of the content element', false, 'image'],
            ['id', 'int', 'uid of the content element', true],
            ['as', 'string', '', false, 'references']
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
        $fileRepository = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\FileRepository::class);
        $files = $fileRepository->findByRelation($arguments['table'], $arguments['field'], $arguments['id']);
        $templateVariableContainer = $renderingContext->getVariableProvider();
        $templateVariableContainer->add($as, $files);
        // $content = $renderChildrenClosure();
        // $templateVariableContainer->remove($as);
    }
}
