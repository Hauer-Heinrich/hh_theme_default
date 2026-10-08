<?php
declare(strict_types=1);

return [
    \GeorgRinger\News\Domain\Model\News::class => [
        'subclasses' => [
            100 => \{{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\Domain\Model\NewsTheme::class,
        ],
    ],
    \{{EXTENSION_VENDOR}}\{{EXTENSION_NAMESPACE}}\Domain\Model\NewsTheme::class => [
        'tableName' => 'tx_news_domain_model_news',
        'recordType' => 100,
    ],
];
