<?php

declare(strict_types=1);

use DI\Container;
use DI\Definition\Source\DefinitionArray;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator(
    [
        new PhpFileProvider(ROOT_DIR . '/config/common/*.php'),
        new PhpFileProvider(ROOT_DIR . '/config/' . (getenv('ENV') ?: 'prod') . '/*.php'),
    ]
);

$config = $aggregator->getMergedConfig();
$definition = new DefinitionArray($config);

return new Container($definition);
