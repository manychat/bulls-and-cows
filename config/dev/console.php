<?php

declare(strict_types=1);

use Doctrine\Migrations\Tools\Console\Command;

return [
    Command\DiffCommand::class => function (): Command\DiffCommand {
        return new Command\DiffCommand();
    },

    Command\MigrateCommand::class => function (): Command\MigrateCommand {
        return new Command\MigrateCommand();
    },

    'config' => [
        'console' => [
            'commands' => [
                Command\DiffCommand::class,
                Command\MigrateCommand::class,
            ],
        ],
    ],
];
