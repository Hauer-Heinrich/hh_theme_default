<?php
declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project. [...]
 */

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\DataProcessing;

// use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use \TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use \TYPO3\CMS\Extbase\Property\PropertyMapper;

/**
 * Class for data processing comma separated categories
 */
class OpeningHoursProcessor implements DataProcessorInterface {

    const DAYSOFWEEK = [
        "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"
    ];

    public function __construct(
        protected readonly PropertyMapper $propertyMapper,
    ) {}

    /**
     * Process data for the content element "My new content element"
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array<string, mixed> $contentObjectConfiguration The configuration of Content Object
     * @param array<string, mixed> $processorConfiguration The configuration of this processor
     * @param array<string, mixed> $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array<mixed> the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData,
    ) {
        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        if(isset($processedData['data']['open_monday'])) {
            unset($processedData['data']['uid']);
            unset($processedData['data']['pid']);
            unset($processedData['data']['tstamp']);
            unset($processedData['data']['crdate']);
            unset($processedData['data']['deleted']);
            unset($processedData['data']['hidden']);
            unset($processedData['data']['sys_language_uid']);
            unset($processedData['data']['l10n_parent']);
            unset($processedData['data']['l10n_state']);
            unset($processedData['data']['l10n_diffsource']);
            unset($processedData['data']['t3ver_oid']);
            unset($processedData['data']['t3ver_wsid']);
            unset($processedData['data']['t3ver_state']);
            unset($processedData['data']['place']);
            unset($processedData['data']['t3ver_stage']);
            unset($processedData['data']['appointment_monday']);
            unset($processedData['data']['appointment_tuesday']);
            unset($processedData['data']['appointment_wednesday']);
            unset($processedData['data']['appointment_thursday']);
            unset($processedData['data']['appointment_friday']);
            unset($processedData['data']['appointment_saturday']);
            unset($processedData['data']['appointment_sunday']);

            $arrayToMap = [];
            foreach ($processedData['data'] as $key => $value) {
                $str = lcfirst(GeneralUtility::underscoredToUpperCamelCase($key));
                $arrayToMap[$str] = $value;
            }

            try {
                $periodOfTime = $this->propertyMapper->convert(
                    $arrayToMap,
                    \HauerHeinrich\HhTtAddressPlaces\Domain\Model\PeriodOfTime::class,
                );

                return $periodOfTime->getStructuredOpeningTimes();
            } catch (\Throwable $th) {
                // throw $th;
            }
        }

        return $processedData;
    }
}
