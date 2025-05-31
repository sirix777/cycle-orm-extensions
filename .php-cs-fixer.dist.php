<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use Sirix\CsFixerConfig\ConfigBuilder;


$srcConfig = ConfigBuilder::create()
    ->inDir(__DIR__ . '/src')
    ->setRules([
        '@PHP81Migration' => true,
        'Gordinskiy/line_length_limit' => ['max_length' => 140],
    ])
    ->getConfig();


$testsConfig = ConfigBuilder::create()
    ->inDir(__DIR__ . '/test')
    ->setRules([
        '@PHP81Migration' => true,
        'Gordinskiy/line_length_limit' => false,
        'php_unit_test_class_requires_covers' => false,
        'php_unit_internal_class' => false,
        'single_line_comment_style' => false,
    ])
    ->getConfig();


return ConfigBuilder::create()
    ->setFinder(
        Finder::create()
            ->append($srcConfig->getFinder())
            ->append($testsConfig->getFinder())
    )
    ->setRules(array_merge(
        $srcConfig->getRules(),
        $testsConfig->getRules()
    ))
    ->getConfig()
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect());
