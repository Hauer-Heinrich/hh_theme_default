<?php

namespace HauerHeinrich\HhThemeDefault\Hooks;

// use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TtAddressFlexFormHook {
    /**
     * @param array $dataStructure
     * @param array $identifier
     * @return array
     */
    public function parseDataStructureByIdentifierPostProcess(array $dataStructure, array $identifier): array {
        if ($identifier['type'] === 'tca' && $identifier['tableName'] === 'tt_content' && $identifier['dataStructureKey'] === 'ttaddress_listview,list') {
            $file = Environment::getPublicPath() . '/typo3conf/ext/hh_theme_default/Configuration/Flexforms/TtAddress.xml';
            $content = file_get_contents($file);
            if ($content) {
                $contentArray = GeneralUtility::xml2array($content);

                // add element/field to an existing tab
                if(array_key_exists('addToExistingSection', $contentArray) && !empty($contentArray['addToExistingSection'])) {
                    foreach ($contentArray['addToExistingSection'] as $key => $value) {
                        if(array_key_exists($key, $dataStructure['sheets'])) {
                            foreach ($contentArray['addToExistingSection'][$key]['ROOT']['el'] as $fieldKey => $fieldValue) {
                                $dataStructure['sheets'][$key]['ROOT']['el'][$fieldKey] = $fieldValue;
                            }
                        }
                    }
                }

                // add a new tab with new elements
                if(array_key_exists('addCompleteNewSection', $contentArray) && !empty($contentArray['addCompleteNewSection'])) {
                    foreach ($contentArray['addCompleteNewSection'] as $tabKey => $tabValue) {
                        $dataStructure['sheets'][$tabKey] = $tabValue;
                    }
                }
            }
        }

        return $dataStructure;
    }
}
