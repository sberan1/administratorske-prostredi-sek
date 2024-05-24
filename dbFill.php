<?php

use Contributte\Nextras\Orm\Generator\Analyser\Database\DatabaseAnalyser;
use Contributte\Nextras\Orm\Generator\Config\Impl\TogetherConfig;
use Contributte\Nextras\Orm\Generator\SimpleFactory;

require __DIR__ . '/vendor/autoload.php';

$config = [
'output' => __DIR__ . '/app/Core/Model/Entity',
    //other options
];
$factory = new SimpleFactory(
new TogetherConfig($config),
new DatabaseAnalyser('pgsql:host=host.docker.internal;port=5432;dbname=postgres;user=interview;password=something;options=--search_path=cz_seksy')
);

$factory->create()->generate();

