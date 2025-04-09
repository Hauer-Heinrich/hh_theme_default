<?php
namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\ViewHelpers;

/*
    Usage:
    <hhdefault:spaceless html="[html-code]">
*/

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use \TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class SpacelessViewHelper extends AbstractViewHelper {
    /**
    * As this ViewHelper renders HTML, the output must not be escaped.
    *
    * @var bool
    */
    protected $escapeOutput = false;

    use CompileWithRenderStatic;

    public function initializeArguments() {
       $this->registerArgument('html', 'string', 'HTML', false);
       $this->registerArgument('emptyLines', 'bool', 'Remove only empty lines.', false);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext){
        if(empty($arguments['html'])) {
            $givenHtml = $renderChildrenClosure();
        } else {
            $givenHtml = $arguments['html'];
        }

        if($arguments['emptyLines'] === true) {
            $html = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $givenHtml);

            return $html;
        }

        $html = preg_replace('/\>\s+\</m', '><', $givenHtml);

        return $html;
    }
}
