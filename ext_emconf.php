<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'GPXViewer',
    'description' => 'Extension with plugin for GPXViewer content element based on GPXViewer from Jürgen Berkemeier (https://www.j-berkemeier.de/GPXViewer/)',
    'category' => 'plugin',
    'author' => '',
    'author_email' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.2',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
