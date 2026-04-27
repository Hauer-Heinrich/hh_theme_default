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
                    'second' => [
                        'title' => '4 : 3',
                        'value' => 4 / 3
                    ],
                    'third' => [
                        'title' => '3 : 4',
                        'value' => 3 / 4
                    ],
                    'fourth' => [
                        'title' => '3 : 2',
                        'value' => 3 / 2
                    ],
                    'five' => [
                        'title' => '2 : 3',
                        'value' => 2 / 3
                    ],
                    'six' => [
                        'title' => '1 : 1',
                        'value' => 1 / 1
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
                        'title' => '16 : 9',
                        'value' => 16 / 9
                    ],
                    'second' => [
                        'title' => '4 : 3',
                        'value' => 4 / 3
                    ],
                    'third' => [
                        'title' => '3 : 4',
                        'value' => 3 / 4
                    ],
                    'fourth' => [
                        'title' => '3 : 2',
                        'value' => 3 / 2
                    ],
                    'five' => [
                        'title' => '2 : 3',
                        'value' => 2 / 3
                    ],
                    'six' => [
                        'title' => '1 : 1',
                        'value' => 1 / 1
                    ],
                ],
                'selectedRatio' => 'NaN',
            ],
        ],
    ];
});
