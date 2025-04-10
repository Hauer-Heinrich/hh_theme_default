<?php
declare(strict_types=1);

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\EventListener;

use \TYPO3\CMS\Core\Page\PageRenderer;

final class AfterBackendPageRenderEventListener {

    public function __construct(private readonly PageRenderer $pageRenderer) {

    }

    public function __invoke(): void {
        // $this->pageRenderer->addCssFile('EXT:dashboard/Resources/Public/Css/Modal/style.css');
        // $this->pageRenderer->addJsFooterFile('EXT:{{EXTENSION_KEY}}/Resources/Public/JavaScript/Backend/author-info.js');
        // $this->pageRenderer->loadJavaScriptModule('@{{EXTENSION_VENDOR_ES6}}/{{EXTENSION_NAMESPACE_ES6}}/author-info.js');
        $this->pageRenderer->loadJavaScriptModule('@{{EXTENSION_VENDOR_ES6}}/{{EXTENSION_NAMESPACE_ES6}}/Backend/index.js');
    }
}
