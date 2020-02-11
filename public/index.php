<?php

declare(strict_types=1);

use Src\Infrastructure\Framework\AppBuilder\APIDirector;

!defined('ROOT_DIR') && define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

APIDirector::build()->run();
