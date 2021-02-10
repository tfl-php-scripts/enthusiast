<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\DowngradeSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/public/enthusiast',
    ]);

    $parameters->set(Option::AUTOLOAD_PATHS, [
        __DIR__ . '/public/enthusiast/Robotess/App.php',
        __DIR__ . '/public/enthusiast/Robotess/Autoloader.php',
        __DIR__ . '/public/enthusiast/Robotess/DeleteFromFl/Form.php',
        __DIR__ . '/public/enthusiast/Robotess/DeleteFromFl/Handler.php',
        __DIR__ . '/public/enthusiast/Robotess/EnthusiastErrorHandler.php',
        __DIR__ . '/public/enthusiast/Robotess/PaginationUtils.php',
        __DIR__ . '/public/enthusiast/Robotess/StringUtils.php',
    ]);

    $parameters->set(Option::SKIP, [
        __DIR__ . '/public/enthusiast/config.sample.php',
        __DIR__ . '/public/enthusiast/config.php',
        __DIR__ . '/public/templates',
        __DIR__ . '/public/enthusiast/Mail.php',
        __DIR__ . '/public/enthusiast/Mail',
        __DIR__ . '/public/enthusiast/PEAR.php',
    ]);

    $parameters->set(Option::SETS, [
        DowngradeSetList::PHP_74,
        DowngradeSetList::PHP_73,
    ]);
};
