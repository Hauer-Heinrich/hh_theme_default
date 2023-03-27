<?php
defined('TYPO3') or die();

call_user_func(function() {
    // Set image cropVariants
    $GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config'] = [
        'type' => 'imageManipulation',
        'cropVariants' => [
            'default' => [
                'title' => 'Default',
                'allowedAspectRatios' => [
                'NaN' => [
                    'title' => 'FREI',
                    'value' => 0.0
                ],
                'first' => [
                    'title' => '16 : 9',
                    'value' => 16 / 9
                ],
                ],
                'selectedRatio' => 'NaN',
            ],
            'smartphone' => [
                'title' => 'Smartphone variant',
                'allowedAspectRatios' => [
                    'NaN' => [
                        'title' => 'FREI',
                        'value' => 0.0
                    ],
                    'first' => [
                        'title' => '4 : 3',
                        'value' => 4 / 3
                    ],
                ],
                'selectedRatio' => 'NaN',
            ],
        ],
    ];

    // RTE for sys_file_reference description field
    // TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    //     'sys_file_reference',
    //     [
    //         'description' => [
    //             'exclude' => 1,
    //             'label' => 'Description (Caption)',
    //             'config' => [
    //                 'type' => 'text',
    //                 'enableRichtext' => true,
    //                 'fieldControl' => [
    //                     'fullScreenRichtext' => [
    //                         'disabled' => false,
    //                     ],
    //                 ],
    //                 'richtextConfiguration' => 'default',
    //             ],
    //         ]
    //     ]
    // );
});
