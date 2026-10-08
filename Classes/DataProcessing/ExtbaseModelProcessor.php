<?php
declare(strict_types=1);

namespace HauerHeinrich\HhThemeDefault\DataProcessing;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

class ExtbaseModelProcessor implements DataProcessorInterface {
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        $as = (string)$cObj->stdWrapValue('as', $processorConfiguration, 'model');
        $modelClass = (string)$cObj->stdWrapValue('modelClass', $processorConfiguration, '');

        if ($modelClass === '' || !class_exists($modelClass) || $cObj->data === []) {
            return $processedData;
        }

        $dataMapper = GeneralUtility::makeInstance(DataMapper::class);
        $processedData[$as] = $dataMapper->map($modelClass, [$cObj->data])[0] ?? null;

        return $processedData;
    }
}
