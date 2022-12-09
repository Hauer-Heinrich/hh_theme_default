<?php
namespace HauerHeinrich\HhThemeDefault\EventListener;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\SingletonInterface;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extensionmanager\Service\ExtensionManagementService as ExtService;
use \TYPO3\CMS\Extbase\Object\ObjectManager;
use \TYPO3\CMS\Extensionmanager\Utility\InstallUtility;

class AfterExtensionInstall implements SingletonInterface {

    /**
     * extensionKey
     *
     * @var string $extensionKey
     */
    protected $extensionKey = '';

    /**
     * logger
     * https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/Logging/Logger/Index.html#logging-logger
     *
     * @var \TYPO3\CMS\Core\Log\Logger $logger
     */
    protected $logger;

    function __construct() {
        $this->extensionKey = 'hh_theme_default';
        $this->logger = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Log\LogManager::class)->getLogger(static::class);
    }

    /**
     * addAdditionalConfiguration
     * copy the dummy_AdditionalConfiguration to typo3conf directory of no AdditonalConfiguration exists
     *
     * @param object $data EventObject
     * @return void
     */
    public function addAdditionalConfiguration(object $data): void {
        if($data->getPackageKey() === $this->extensionKey) {
            $path = GeneralUtility::getFileAbsFileName('typo3conf');

            // TYPO3 <= 11
            // @deprecated version <= 11
            if(!file_exists($path.'/AdditionalConfiguration.php')) {
                copy($path.'/ext/'.$this->extensionKey.'/Configuration/Typo3/dummy_files/dummy_AdditionalConfiguration.php', $path.'/AdditionalConfiguration.php');
                if (!file_exists($path.'/AdditionalConfiguration.php')) {
                    $logMessage = 'typo3conf/AdditionalConfiguration.php can not copied, maybe file permissions...? (you can find the theme_default AdditionalConfiguration file at typo3conf/ext/'.$this->extensionKey.'/Configuration/Typo3/dummy_files';
                    $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, $logMessage);
                }
            } else {
                $logMessage = 'typo3conf/AdditionalConfiguration.php not created/copied because it seems that this file already exist!';
                $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::WARNING, $logMessage);
            }

            // TYPO3 >= 12
            if(!file_exists($path.'/system/additional.php')) {
                copy($path.'/ext/'.$this->extensionKey.'/dummy_files/dummy_system/additional.php', $path.'/system/additional.php');
                if (!file_exists($path.'/system/additional.php')) {
                    $logMessage = 'typo3conf/system/additional.php can not copied, maybe file permissions...? (you can find the theme_default AdditionalConfiguration file at typo3conf/ext/'.$this->extensionKey.'/dummy_files';
                    $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, $logMessage);
                }
            } else {
                $logMessage = 'typo3conf/system/additional.php not created/copied because it seems that this file already exist!';
                $this->logger->log(\TYPO3\CMS\Core\Log\LogLevel::WARNING, $logMessage);
            }
        }
    }

    /**
     * disableExtensions
     * which are listed in file ext_disable.php
     *
     * @param object $data EventObject
     * @return void
     */
    public function disableExtensions(object $data): void {
        if($data->getPackageKey() === $this->extensionKey) {
            $path = GeneralUtility::getFileAbsFileName('EXT:'.$this->extensionKey.'/ext_disable.php');

            if(file_exists($path)) {
                $extService = GeneralUtility::makeInstance(ExtService::class);
                $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
                $disableExtensions = include $path;

                if(!empty($disableExtensions) && is_array($disableExtensions)) {
                    foreach ($disableExtensions as $key => $value) {
                        if($extService->isAvailable($value)) {
                            $objectManager->get(InstallUtility::class)->uninstall($value);
                        }
                    }
                }
            }
        }
    }
}
