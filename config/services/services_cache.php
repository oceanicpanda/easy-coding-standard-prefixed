<?php

declare (strict_types=1);
namespace _PhpScoper06c5fb6c14ed;

use _PhpScoper06c5fb6c14ed\Psr\Cache\CacheItemPoolInterface;
use _PhpScoper06c5fb6c14ed\Psr\SimpleCache\CacheInterface;
use _PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Psr16Cache;
use _PhpScoper06c5fb6c14ed\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoper06c5fb6c14ed\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->set(\_PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScoper06c5fb6c14ed\Psr\SimpleCache\CacheInterface::class, \_PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->args(['$namespace' => '%cache_namespace%', '$defaultLifetime' => 0, '$directory' => '%cache_directory%']);
    $services->alias(\_PhpScoper06c5fb6c14ed\Psr\Cache\CacheItemPoolInterface::class, \_PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScoper06c5fb6c14ed\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
