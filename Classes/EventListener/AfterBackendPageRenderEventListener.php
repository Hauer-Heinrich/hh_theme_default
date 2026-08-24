<?php
declare(strict_types=1);

namespace HauerHeinrich\HhThemeDefault\EventListener;

use TYPO3\CMS\Core\Page\PageRenderer;

final class AfterBackendPageRenderEventListener {

    public function __construct(private readonly PageRenderer $pageRenderer) {

    }

    public function __invoke(): void {
        // $this->pageRenderer->addCssFile('EXT:dashboard/Resources/Public/Css/Modal/style.css');
        $this->pageRenderer->loadJavaScriptModule('@hauerheinrich/hh-theme-default/Backend/index.js');
    }
}
