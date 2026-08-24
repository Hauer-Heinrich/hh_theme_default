<?php
declare(strict_types=1);

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\Helper;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Attribute\AsAllowedCallable;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class GetTextFromFileHelper {

    /**
     * Output the current time in red letters
     *
     * @param string Empty string (no content to process)
     * @param array TypoScript configuration
     * @param ServerRequestInterface $request
     * @return string HTML output, showing the current server time.
     */
    #[AsAllowedCallable]
    public function getText(string $content, array $conf, ServerRequestInterface $request): string {
        $string = \file_get_contents('asdf');
        if(empty($string) || $string === false) {
            return '';
        }

        return $string;
    }

    /**
     * Output the current time in red letters
     *
     * @param string Empty string (no content to process)
     * @param array TypoScript configuration
     * @param ServerRequestInterface $request
     * @return string HTML output, showing the current server time.
     */
    #[AsAllowedCallable]
    public function setInlineCss(string $content, array $conf, ServerRequestInterface $request): void {
        if(!isset($conf['settings.']['file'])) {
            return;
        }

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile(
            file: $conf['settings.']['file'],
            forceOnTop: true,
            inline: true
        );
    }
}
