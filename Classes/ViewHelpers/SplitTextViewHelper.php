<?php
namespace HauerHeinrich\HhThemeDefault\ViewHelpers;

/*
    Usage:
    <hh:splitText text="some text |split| blubb">
    <hh:splitText text="some text |split| blubb" class="myCssClass">
*/

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use \TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class SplitTextViewHelper extends AbstractViewHelper {
    /**
    * As this ViewHelper renders HTML, the output must not be escaped.
    *
    * @var bool
    */
    protected $escapeOutput = false;

    use CompileWithRenderStatic;

    public function initializeArguments() {
        $this->registerArgument('text', 'string', 'Text that will be splitt (e.g. sometext..|mystring|..sometext will be wrapped into a separate container)', true);
        $this->registerArgument('class', 'string', 'Optionally add a CSS Class to the splitted container (e.g. myCssClass)', false);
        $this->registerArgument('tag', 'string', 'Optionally use a different html tag (e.g. strong, div, a)', false);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext) {
        $cssClass = !empty($arguments['class']) ? " class='".$arguments['class']."'" : "";
        $tag = !empty($arguments['tag']) ? $arguments['tag'] : "span";
        $str = self::nth_replace($arguments['text'], "*", "|", 2);
        $str = str_replace(["*", "|"], ["<{$tag}{$cssClass}>", "</{$tag}>"], $str);

        return $str;
    }

    public static function nth_replace($string, $find, $replace, $n) {
        $count = 0;
        for($i=0; $i<strlen($string); $i++) {
            if($string[$i] == $find) {
                $count++;
            }

            if($count == $n) {
                $string[$i] = $replace;
                $count = 0;
            }
        }

        return $string;
    }
}
