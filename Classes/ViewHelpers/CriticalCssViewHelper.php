<?php
declare(strict_types=1);

namespace HauerHeinrich\HhThemeDefault\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

final class CriticalCssViewHelper extends AbstractViewHelper {
    public function initializeArguments(): void {
        $this->registerArgument('href', 'string', 'Pfad zur CSS-Datei, z.B. EXT:...', true);
    }

    public function render(): string {
        GeneralUtility::makeInstance(PageRenderer::class)->addCssLibrary(
            file: $this->arguments['href'],
            compress: false,
            forceOnTop: true,
            excludeFromConcatenation: true,
            inline: true
        );

        return '';
    }
}
