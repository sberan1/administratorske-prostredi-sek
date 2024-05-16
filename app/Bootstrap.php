<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;
use Symfony\Component\Console\Application as SymfonyApplication;


class Bootstrap
{
	public static function boot(): Configurator
	{
		$configurator = new Configurator;
		$appDir = dirname(__DIR__);

		$configurator->setDebugMode(true);
		$configurator->enableTracy($appDir . '/log');

		$configurator->setTempDirectory($appDir . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

		$configurator->addConfig($appDir . '/config/common.neon');
		$configurator->addConfig($appDir . '/config/services.neon');

		return $configurator;
	}

    public static function runCli(): void
    {
        self::boot()
            ->addStaticParameters([
                'scope' => 'cli',
            ])
            ->createContainer()
            ->getByType(SymfonyApplication::class)
            ->run();
    }

}
