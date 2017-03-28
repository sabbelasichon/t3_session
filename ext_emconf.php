<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'SessionStorage Wrapper for Backend and Frontend',
    'description' => 'A simple extension to have a consistent api to use TYPO3 Session in Backend and Frontend',
    'category' => 'plugin',
    'author' => 'Sebastian Schreiber',
    'author_email' => 'breakpoint@schreibersebastian.de',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '6.2.0-7.6.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Ssch\\T3Session\\' => 'Classes',
        ],
    ],
    'autoload-dev' => [
        'psr-4' => [
            'Ssch\\T3Session\\Tests\\' => 'Tests',
        ],
    ],
];
