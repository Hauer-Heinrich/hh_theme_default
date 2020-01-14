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
 *  <hh:phoneNumber number="0564846 64 - 5">
 */

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PhoneNumberViewHelper extends AbstractViewHelper {
    public function initializeArguments() {
        $this->registerArgument('number', 'string', 'Phone number, dont work with numbers like +49 (0) 3425..', true);
        $this->registerArgument('country', 'string', 'country number, default: +49', false);
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $number = $arguments['number'];
        $country_code = $arguments['country'];

        // Look up the country dialling code for this number:
        if (empty($country_code)) {
            $pfx = '+49';
        } else {
            $pfx = $country_code;
        }

        // Strip spaces and non-numeric characters:
        $n = preg_replace("/[^0-9]/", "", $number);

        // Strip out leading zeros:
        $n = ltrim($n, '0');

        // Check if the number doesn't already start with the correct dialling code:
        if (!strrpos($n, $pfx, -strlen($n))) {
            $n = $pfx.$n;
        }

        return $n;
    }
}
