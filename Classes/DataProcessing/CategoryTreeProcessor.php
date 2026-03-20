<?php
declare(strict_types=1);

/*
 * Customized by Hauer-Heinrich for more imageorient options
 *
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

namespace {{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\DataProcessing;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class CategoryTreeProcessor implements DataProcessorInterface {
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        if (isset($processorConfiguration['if.']) && !$cObj->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        $startingPoints = $cObj->stdWrapValue('startingPoints', $processorConfiguration);
        // The variable to be used within the result
        $targetVariableName = $cObj->stdWrapValue('as', $processorConfiguration, 'categoryTree');

        if (!$startingPoints) {
            return $processedData;
        }

        $startingUids = GeneralUtility::intExplode(',', $startingPoints, true);
        $categories = $this->fetchCategories();
        $tree = $this->buildTree($categories, $startingUids);
        $processedData[$targetVariableName] = $tree;

        return $processedData;
    }

    protected function fetchCategories(): array {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('sys_category');

        $rows = $queryBuilder
            ->select('*')
            ->from('sys_category')
            ->where(
                $queryBuilder->expr()->eq('deleted', 0),
                $queryBuilder->expr()->eq('hidden', 0)
            )
            ->orderBy('sorting')
            ->executeQuery()
            ->fetchAllAssociative();

        $categories = [];

        foreach ($rows as $row) {
            $row['children'] = [];
            $categories[$row['uid']] = $row;
        }

        return $categories;
    }

    protected function buildTree(array $categories, array $startingUids): array {
        $tree = [];

        foreach ($categories as $uid => &$category) {
            $parent = (int)$category['parent'];

            if ($parent && isset($categories[$parent])) {
                $categories[$parent]['children'][] = &$category;
            }
        }

        foreach ($startingUids as $startUid) {
            if (isset($categories[$startUid])) {
                $tree[] = $categories[$startUid];
            }
        }

        return $tree;
    }
}
