<?php
declare(strict_types=1);

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
 *   xmlns:hhdefault="http://typo3.org/ns/VENDOR/NAMESPACE/ViewHelpers"
 *   data-namespace-typo3-fluid="true">
 *
 *  <hhdefault:phoneNumber number="0564846 64 - 5"> -> 056484664
 *  <hhdefault:phoneNumber number="+49 564846 64 - 5"> -> +4956484664
 *  <hhdefault:phoneNumber number="0564846 64 - 5" country="+49"> -> +4956485664
 */

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PhoneNumberViewHelper extends AbstractViewHelper {
    public function initializeArguments() {
        $this->registerArgument('number', 'string', 'Phone number, dont work with numbers like +49 (0) 3425..', true);
        $this->registerArgument('country', 'string', 'country number, default: +49', false);
    }

    public function render(): string {
        $number = $this->arguments['number'];
        $country_code = $this->arguments['country'] ?? null;

        // Strip spaces and non-numeric characters / allow starting + sign:
        $n = preg_replace("/(?!^\\+)[^0-9]/", "", $number);

        // Check if the number doesn't already start with the correct dialling code:
        if (!empty($country_code) && !str_starts_with($n, $country_code)) {
            // Strip out leading zeros:
            $n = ltrim($n, '0');

            $n = $country_code.$n;
        }

        return $n;
    }
}
