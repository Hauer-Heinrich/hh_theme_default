<?php
namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\ViewHelpers;

/*
    Usage:
    <hhdefault:spaceless html="[html-code]">
*/

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class SpacelessViewHelper extends AbstractViewHelper {
    /**
    * As this ViewHelper renders HTML, the output must not be escaped.
    *
    * @var bool
    */
    protected $escapeOutput = false;

    public function initializeArguments(): void {
       $this->registerArgument('html', 'string', 'HTML', false);
       $this->registerArgument('emptyLines', 'bool', 'Remove only empty lines.', false);
    }

    public function render(): string {
        if(empty($this->arguments['html'])) {
            $givenHtml = $this->renderChildren();;
        } else {
            $givenHtml = $this->arguments['html'];
        }

        if($this->arguments['emptyLines'] === true) {
            $html = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $givenHtml);

            return $html;
        }

        $html = preg_replace('/\>\s+\</m', '><', $givenHtml);

        return $html;
    }
}
