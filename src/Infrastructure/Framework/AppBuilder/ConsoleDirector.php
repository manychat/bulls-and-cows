<?php

declare(strict_types=1);

namespace Src\Infrastructure\Framework\AppBuilder;

use Doctrine\DBAL\Tools\Console\ConsoleRunner as DBALRunnerAlias;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner as ORMConsoleRunner;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Src\Infrastructure\Environment\Loader as EnvLoader;
use Symfony\Component\Console\Application;

final class ConsoleDirector
{
    public static function build(): Application
    {
        (new EnvLoader())->load();

        $container = ContainerBuilder::build();
        $cli = new Application('Application console');

        $entityManager = $container->get(EntityManagerInterface::class);
        $connection = $entityManager->getConnection();

        $configuration = new Configuration($connection);
        $configuration->setMigrationsDirectory('src/Data/Migration');
        $configuration->setMigrationsNamespace('Src\Data\Migration');

        $cli->getHelperSet()->set(new EntityManagerHelper($entityManager), 'em');
        $cli->getHelperSet()->set(new ConfigurationHelper($connection, $configuration), 'configuration');
        $cli->getHelperSet()->set(new ConnectionHelper($connection), 'db');

        ORMConsoleRunner::addCommands($cli);
        DBALRunnerAlias::addCommands($cli);

        $commands = $container->get('config')['console']['commands'] ?? [];
        array_map(
            function (string $class) use ($cli, $container): void {
                if ($instance = $container->get($class)) {
                    $cli->add($container->get($class));
                }
            },
            $commands
        );

        return $cli;
    }
}
