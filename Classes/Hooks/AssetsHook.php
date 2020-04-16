<?php
declare(strict_types = 1);

namespace HauerHeinrich\HhThemeDefault\Hooks;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class AssetsHook {

    /**
     * extensionKey
     *
     * @var string
     */
    protected $extensionKey = '';

    public function __construct() {
        $this->extensionKey = 'hh_theme_default';
    }

    /**
     * @param object $caller
     * @param boolean $shouldUsePageCache
     * @return boolean
     */
    public function usePageCache($caller, $shouldUsePageCache) {
        $assetsArray = $this->addAssets();
        if (!empty($assetsArray['Header']['css'])) {
            $assetsCss = implode(LF, $assetsArray['Header']['css']);
        }
        if (!empty($assetsArray['Header']['js'])) {
            $assetsJs = implode(LF, $assetsArray['Header']['js']);
        }

        $assetsHeader = $assetsCss . $assetsJs;

        if (!empty($assetsArray['Footer']['js'])) {
            $assetsFooterJs = implode(LF, $assetsArray['Footer']['js']);
        }

        $assetsFooter = $assetsFooterJs;

        $this->insertAssetsAtMarker('Header', $assetsHeader);
        $this->insertAssetsAtMarker('Footer', $assetsFooter);

        return $shouldUsePageCache;
    }

    /**
     * @param string $markerName
     * @param mixed $assets
     * @return void
     */
    protected function insertAssetsAtMarker($markerName, $assets = null) {
        $assetMarker = '<!-- ThemeAssets' . $markerName . ' -->';
        if (false === strpos($GLOBALS['TSFE']->content, $assetMarker)) {
            $inFooter = (boolean) (false !== strpos($markerName, 'Footer'));
            $tag = true === $inFooter ? '</body>' : '</head>';
            $content = $GLOBALS['TSFE']->content;
            $position = strrpos($content, $tag);

            if ($position) {
                $GLOBALS['TSFE']->content = substr_replace($content, $assetMarker . LF, $position, 0);
            }
        }

        $chunk = $assets;

        // if (true === is_array($assets)) {
        //     $chunk = $this->buildAssetsChunk($assets);
        // } else {
        //     $chunk = $assets;
        // }

        $GLOBALS['TSFE']->content = str_replace($assetMarker, $chunk, $GLOBALS['TSFE']->content);
    }

    /**
     * addAssets
     *
     * @return array
    */
    public function addAssets(): array {
        // $this->pageRenderer->addHeaderData('<script type="application/json" class="'.$arguments['class'].'">'.trim($renderChildrenClosure()).'</script>');

        // $this->pageRenderer->addCssFile($path, 'stylesheet', 'all', '', true, false, '', $arguments['exclude'] );

        // $this->pageRenderer->addJsFile($path, '', true, false, '', $arguments['exclude'], '|', false, '', true);

        // $this->pageRenderer->addJsFooterFile($path, '', true, false, '', $arguments['exclude'], '|', false, '', true);

        // $this->setHTMLCodeHead($htmlHead);

        // $this->setHTMLCodeBodyBottom($htmlBodyBottom);

        // <link rel="stylesheet" type="text/css" href="theme.css">

        $assets = [];
        if (!empty($GLOBALS[$this->extensionKey]['assets'])) {

            $assetsCss = $GLOBALS[$this->extensionKey]['assets']['css'];
            $assetsJs = $GLOBALS[$this->extensionKey]['assets']['js'];

            $assetsCssCustom = $GLOBALS[$this->extensionKey]['assets']['custom']['css'];
            $assetsJsCustom = $GLOBALS[$this->extensionKey]['assets']['custom']['js'];

            if (!empty($assetsCss)) {
                ksort($assetsCss);

                foreach ($assetsCss as $key => $value) {

                    if ( substr($value['path'], 0, 4) === "EXT:") {
                        $path = '/typo3conf/' . explode('typo3conf/', GeneralUtility::getFileAbsFileName($value['path']))[1];
                    } else {
                        $path = $value['path'];
                    }
                    $assets['Header']['css'][] = '<link rel="stylesheet" type="text/css" href="'.$path.'" media="all">';
                    // $this->pageRenderer->addCssFile($value['path'], 'stylesheet', 'all', '', true, false, '', true);
                }
            }

            if (!empty($assetsJs)) {
                ksort($assetsJs);

                // ($file, $type = 'text/javascript', $compress = true, $forceOnTop = false, $allWrap = '', $excludeFromConcatenation = false, $splitChar = '|', $async = false, $integrity = '', $defer = false, $crossorigin = '')
                foreach ($assetsJs as $key => $value) {
                    $position = 'Header';
                    // if ($value['position'] === 'head') {
                    //     // $this->pageRenderer->addJsFile($value['path'], '', true, false, '', true, '|', $value['async'], '', $value['defer'], '');
                    // }
                    if (strtolower($value['position']) === 'footer') {
                        $position = 'Footer';
                        // $this->pageRenderer->addJsFooterFile($value['path'], '', true, false, '', true, '|', $value['async'], '', $value['defer'], '');
                    }

                    if ( substr($value['path'], 0, 4) === "EXT:") {
                        $path = '/typo3conf/' . explode('typo3conf/', GeneralUtility::getFileAbsFileName($value['path']))[1];
                    } else {
                        $path = $value['path'];
                    }

                    $async = '';
                    if($value['async']) {
                        $async = 'async';
                    }

                    $defer = '';
                    if ($value['defer']) {
                        $defer = 'defer';
                    }

                    $assets[$position]['js'][] = '<script src="'.$path.'" '. $async . $defer .'></script>';
                }
            }

            if (!empty($assetsCssCustom)) {
                foreach ($assetsCssCustom as $key => $value) {
                    if ( substr($value['path'], 0, 4) === "EXT:") {
                        $path = '/typo3conf/' . explode('typo3conf/', GeneralUtility::getFileAbsFileName($value['path']))[1];
                    } else {
                        $path = $value['path'];
                    }
                    $assets['Header']['css'][] = '<link rel="stylesheet" type="text/css" href="'.$path.'" media="all">';
                    // $this->pageRenderer->addCssFile($value['path'], 'stylesheet', 'all', '', true, false, '', true);
                }
            }

            // TODO: switch position footer or head
            if (!empty($assetsJsCustom)) {
                foreach ($assetsJsCustom as $key => $value) {
                    if ( substr($value['path'], 0, 4) === "EXT:") {
                        $path = '/typo3conf/' . explode('typo3conf/', GeneralUtility::getFileAbsFileName($value['path']))[1];
                    } else {
                        $path = $value['path'];
                    }

                    $async = '';
                    if($value['async']) {
                        $async = 'async';
                    }

                    $defer = '';
                    if ($value['defer']) {
                        $defer = 'defer';
                    }

                    $assets['Footer']['js'][] = '<script src="'.$path.'" '. $async . $defer .'></script>';
                    // $this->pageRenderer->addJsFooterFile($value['path'], '', true, false, '', true, '|', $value['async'], '', $value['defer'], '');
                }
            }
        }

        return $assets;
    }
}
