<?php
namespace HauerHeinrich\{{EXTENSION_NAMESPACE}}\ViewHelpers;

/*
    Usage:
    <hh:getHtmlFromUrl url="https://www.domain.tld">
*/

// use \DOMDocument;
// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use \TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class GetHtmlFromUrlViewHelper extends AbstractViewHelper {
    /**
    * As this ViewHelper renders HTML, the output must not be escaped.
    *
    * @var bool
    */
    protected $escapeOutput = false;

    use CompileWithRenderStatic;

    public function initializeArguments() {
       $this->registerArgument('url', 'string', 'URL', true);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext){
        // $html = file_get_contents($arguments['url']);
        // $doc = new DOMDocument;
        // $doc->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Initiate the Request Factory, which allows to run multiple requests
        /** @var \TYPO3\CMS\Core\Http\RequestFactory $requestFactory */
        $requestFactory = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Http\RequestFactory::class);
        $additionalOptions = [
            // Additional headers for this specific request
            'headers' => ['Cache-Control' => 'no-cache'],
            // Additional options, see http://docs.guzzlephp.org/en/latest/request-options.html
            'allow_redirects' => false,
            'cookies' => false,
        ];
        // Return a PSR-7 compliant response object
        $response = $requestFactory->request($arguments['url'], 'GET', $additionalOptions);
        // Get the content as a string on a successful request
        if ($response->getStatusCode() === 200) {
            if (strpos($response->getHeaderLine('Content-Type'), 'text/html') === 0) {
                return $content = $response->getBody()->getContents();
            }
        }

        return "error";
    }
}
