<?php

declare (strict_types=1);
namespace _PhpScoper514703a076a2;

use _PhpScoper514703a076a2\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\FifthElement;
use Symplify\Skipper\Tests\Skipper\Skipper\Fixture\Element\SixthSense;
use Symplify\Skipper\ValueObject\Option;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SKIP, [
        // windows like path
        '*\\SomeSkipped\\*',
        // elements
        FifthElement::class,
        SixthSense::class,
    ]);
};
