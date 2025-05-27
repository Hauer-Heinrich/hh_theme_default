<?php
declare(strict_types=1);

return [
    // News has special extends configuration, see docu of EXT:news
    // \HauerHeinrich\HhThemeDefault\Domain\Model\News::class => [
    //     'tableName' => 'tx_news_domain_model_news',
    // ],

    \HauerHeinrich\HhThemeDefault\Domain\Model\Address::class => [
        'tableName' => 'tt_address',
    ],
];
