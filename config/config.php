<?php

declare (strict_types=1);
namespace _PhpScoper78e1a27e740b;

use _PhpScoper78e1a27e740b\Nette\Utils\Strings;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $containerConfigurator->import(__DIR__ . '/services.php');
    $containerConfigurator->import(__DIR__ . '/../packages/*/config/*.php');
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::INDENTATION, Option::INDENTATION_SPACES);
    $parameters->set(Option::LINE_ENDING, \PHP_EOL);
    $parameters->set(Option::CACHE_DIRECTORY, \sys_get_temp_dir() . '/_changed_files_detector%env(TEST_SUFFIX)%');
    $parameters->set(Option::CACHE_NAMESPACE, Strings::webalize(\getcwd()));
    $parameters->set(Option::PATHS, []);
    $parameters->set(Option::SETS, []);
    $parameters->set(Option::FILE_EXTENSIONS, ['php']);
    $parameters->set('env(TEST_SUFFIX)', '');
};
