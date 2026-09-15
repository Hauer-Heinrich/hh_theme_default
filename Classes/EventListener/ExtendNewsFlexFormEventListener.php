<?php
declare(strict_types=1);

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Configuration\Event\AfterFlexFormDataStructureParsedEvent;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsEventListener(identifier: 'hh-theme-default/extend-news-flexform')]
final class ExtendNewsFlexFormEventListener {

    private string $flexFormFile = 'EXT:{{EXTENSION_KEY}}/Configuration/FlexForms/NewsExtension.xml';

    public function __invoke(AfterFlexFormDataStructureParsedEvent $event): void {
        $identifier = $event->getIdentifier();

        if (($identifier['tableName'] ?? '') !== 'tt_content'
            || !str_contains((string)($identifier['dataStructureKey'] ?? ''), 'news_pi1')
        ) {
            return;
        }

        $dataStructure = $event->getDataStructure();
        $additional = file_get_contents(
            GeneralUtility::getFileAbsFileName($this->flexFormFile)
        );

        if ($additional !== false) {
            ArrayUtility::mergeRecursiveWithOverrule(
                $dataStructure,
                GeneralUtility::xml2array($additional)
            );
        }

        $event->setDataStructure($dataStructure);
    }
}
