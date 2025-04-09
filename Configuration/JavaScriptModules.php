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
        '@{{EXTENSION_VENDOR}}/{{EXTENSION_NAMESPACE_ES6}}/Backend/' => 'EXT:{{EXTENSION_KEY}}/Resources/Public/JavaScript/backend/',
    ],
];
