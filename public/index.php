<?php

declare(strict_types=1);

use Src\Infrastructure\Framework\AppBuilder\AppDirector;

!defined('ROOT_DIR') && define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

AppDirector::build()->run();
