<?php
declare(strict_types=1);

/*
 * Customized by Hauer-Heinrich for more imageorient options
 *
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\DataProcessing;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * This data processor will calculate rows, columns and dimensions for a gallery
 * based on several settings and can be used for f.i. the CType "textmedia"
 *
 * The output will be an array which contains the rows and columns,
 * including the file references and the calculated width and height for each media element,
 * but also some more information of the gallery, like position, width and counters
 *
 * Example TypoScript configuration: see original GalleryProcessor
 */
class GalleryProcessor extends \TYPO3\CMS\Frontend\DataProcessing\GalleryProcessor {

    /**
     * Matching the tt_content field towards the imageOrient option
     *
     * @var array
     */
    protected $availableGalleryPositions = [
        'horizontal' => [
            'center' => [0, 8],
            'right' => [1, 9, 17, 25, 100, 150],
            'left' => [2, 10, 18, 26, 110, 160],
        ],
        'vertical' => [
            'above' => [0, 1, 2],
            'intext' => [17, 18, 25, 26, 100, 110, 150, 160],
            'below' => [8, 9, 10],
        ],
    ];

    /**
     * Define the gallery position
     *
     * Gallery has a horizontal and a vertical position towards the text
     * and a possible wrapping of the text around the gallery.
     */
    protected function determineGalleryPosition() {
        foreach ($this->availableGalleryPositions as $positionDirectionKey => $positionDirectionValue) {
            foreach ($positionDirectionValue as $positionKey => $positionArray) {
                if (in_array($this->mediaOrientation, $positionArray, true)) {
                    $this->galleryData['position'][$positionDirectionKey] = $positionKey;
                }
            }
        }

        if (
            $this->mediaOrientation === 25
            || $this->mediaOrientation === 26
            || $this->mediaOrientation === 100
            || $this->mediaOrientation === 110
            || $this->mediaOrientation === 150
            || $this->mediaOrientation === 160
        ) {
            $this->galleryData['position']['noWrap'] = true;
        }

        if($this->mediaOrientation === 100 || $this->mediaOrientation === 110) {
            $this->galleryData['position']['center'] = true;
            $this->galleryData['position']['cover'] = false;
        }

        if($this->mediaOrientation === 150 || $this->mediaOrientation === 160) {
            $this->galleryData['position']['cover'] = true;
            $this->galleryData['position']['center'] = false;
        }
    }
}
