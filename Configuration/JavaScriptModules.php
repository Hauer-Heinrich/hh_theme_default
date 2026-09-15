<?php

return [
    // required import configurations of other extensions,
    // in case a module imports from another package
    'dependencies' => ['backend'],
    'tags' => [
        'backend.form',
    ],
    'imports' => [
        // recursive definiton, all *.js files in this folder are import-mapped
        // trailing slash is required per importmap-specification
        '@hauerheinrich/hh-theme-default/Backend/' => 'EXT:hh_theme_default/Resources/Public/JavaScript/backend/',
    ],
];
