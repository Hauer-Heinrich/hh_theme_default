<?php
declare(strict_types = 1);

namespace HauerHeinrich\HhThemeDefault\Hooks;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Page\PageRenderer;

class AssetsHook {

    /**
     * pageRenderer
     *
     * @var TYPO3\\CMS\\Core\\Page\\PageRenderer
     */
    protected $pageRenderer;

    public function __construct() {
        $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
    }

    /**
     * addAssets
     *
     * @param array $parameters
     * @return string
    */
    public function addAssets(&$parameters) {
        // $this->pageRenderer->addHeaderData('<script type="application/json" class="'.$arguments['class'].'">'.trim($renderChildrenClosure()).'</script>');

        // $this->pageRenderer->addCssFile($path, 'stylesheet', 'all', '', true, false, '', $arguments['exclude'] );

        // $this->pageRenderer->addJsFile($path, '', true, false, '', $arguments['exclude'], '|', false, '', true);

        // $this->pageRenderer->addJsFooterFile($path, '', true, false, '', $arguments['exclude'], '|', false, '', true);

        // $this->setHTMLCodeHead($htmlHead);

        // $this->setHTMLCodeBodyBottom($htmlBodyBottom);

        // <link rel="stylesheet" type="text/css" href="theme.css">

        $assetsCss = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hh_theme_default']['assets']['css'];
        $assetsJs = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hh_theme_default']['assets']['js'];

        $assetsCssCustom = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hh_theme_default']['assets']['custom']['css'];
        $assetsJsCustom = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['hh_theme_default']['assets']['custom']['js'];

        if (!empty($assetsCss)) {
            ksort($assetsCss);

            foreach ($assetsCss as $key => $value) {
                $this->pageRenderer->addCssFile($value, 'stylesheet', 'all', '', true, false, '', true);
            }
        }

        if (!empty($assetsJs)) {
            ksort($assetsJs);

            foreach ($assetsJs as $key => $value) {
                $this->pageRenderer->addJsFooterFile($value, '', true, false, '', true, '|', false, '', true);
            }
        }

        if (!empty($assetsCssCustom)) {
            foreach ($assetsCssCustom as $key => $value) {
                $this->pageRenderer->addCssFile($value, 'stylesheet', 'all', '', true, false, '', true);
            }
        }

        if (!empty($assetsJsCustom)) {
            foreach ($assetsJsCustom as $key => $value) {
                $this->pageRenderer->addJsFooterFile($value, '', true, false, '', true, '|', false, '', true);
            }
        }
    }
}
