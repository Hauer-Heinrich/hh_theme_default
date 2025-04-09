<?php
declare(strict_types=1);

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\EventListener;

use \TYPO3\CMS\Core\Page\PageRenderer;

final class AfterBackendPageRenderEventListener {

    public function __construct(private readonly PageRenderer $pageRenderer) {

    }

    public function __invoke(): void {
        // $this->pageRenderer->addCssFile('EXT:dashboard/Resources/Public/Css/Modal/style.css');
        // $this->pageRenderer->addJsFooterFile('EXT:hh_theme_default/Resources/Public/JavaScript/Backend/author-info.js');
        // $this->pageRenderer->loadJavaScriptModule('@{{EXTENSION_VENDOR}}/hh-theme-default/author-info.js');
        $this->pageRenderer->loadJavaScriptModule('@{{EXTENSION_VENDOR}}/hh-theme-default/Backend/index.js');
    }
}
