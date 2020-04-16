<?php
namespace HauerHeinrich\HhThemeDefault\Hooks;

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

use \TYPO3\CMS\Backend\Controller\BackendController;
use \TYPO3\CMS\Core\Page\PageRenderer;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class adds Filelist related JavaScript to the backend
 */
class BackendControllerHook {

    protected $extensionKey;

    public function __construct() {
        $this->extensionKey = 'hh_theme_default';
    }

    /**
     * Adds Filelist Css used e.g. by context menu
     *
     * @param array $configuration
     * @param BackendController $backendController
     */
    public function addCss(array $configuration, BackendController $backendController) {
        // made oldschool via ext_tables.php
    }

    /**
     * Adds Filelist JavaScript used e.g. by context menu
     *
     * @param array $configuration
     * @param BackendController $backendController
     */
    public function addJavaScript(array $configuration, BackendController $backendController) {
        $path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($this->extensionKey);

        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->loadRequireJsModule('TYPO3/CMS/HhThemeDefault/Backend/Bemain');
    }
}
