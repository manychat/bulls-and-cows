#!/usr/bin/env php
<?php

declare(strict_types=1);

use Src\Shared\Infrastructure\Framework\AppBuilder\ConsoleDirector;

!defined('ROOT_DIR') && define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

ConsoleDirector::build()->run();
