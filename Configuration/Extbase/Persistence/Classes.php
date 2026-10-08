<?php
declare(strict_types=1);

return [
    \GeorgRinger\News\Domain\Model\News::class => [
        'subclasses' => [
            100 => \HauerHeinrich\HhThemeDefault\Domain\Model\NewsTheme::class,
        ],
    ],
    \HauerHeinrich\HhThemeDefault\Domain\Model\NewsTheme::class => [
        'tableName' => 'tx_news_domain_model_news',
        'recordType' => 100,
    ],
];
