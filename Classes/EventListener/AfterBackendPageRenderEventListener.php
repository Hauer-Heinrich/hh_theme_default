<?php
declare(strict_types=1);

namespace HauerHeinrich\HhThemeDefault\EventListener;

use \TYPO3\CMS\Core\Page\PageRenderer;

final class AfterBackendPageRenderEventListener {

    public function __construct(private readonly PageRenderer $pageRenderer) {

    }

    public function __invoke(): void {
        // $this->pageRenderer->addCssFile('EXT:dashboard/Resources/Public/Css/Modal/style.css');
        // $this->pageRenderer->addJsFooterFile('EXT:hh_theme_default/Resources/Public/JavaScript/Backend/author-info.js');
        // $this->pageRenderer->loadJavaScriptModule('@HauerHeinrich/hh-theme-default/author-info.js');
        $this->pageRenderer->loadJavaScriptModule('@HauerHeinrich/hh-theme-default/Backend/index.js');
    }
}
