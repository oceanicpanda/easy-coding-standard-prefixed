<?php

declare (strict_types=1);
namespace _PhpScoperf62d28230928;

use _PhpScoperf62d28230928\Psr\Cache\CacheItemPoolInterface;
use _PhpScoperf62d28230928\Psr\SimpleCache\CacheInterface;
use _PhpScoperf62d28230928\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoperf62d28230928\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoperf62d28230928\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoperf62d28230928\Symfony\Component\Cache\Psr16Cache;
use _PhpScoperf62d28230928\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (\_PhpScoperf62d28230928\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->set(\_PhpScoperf62d28230928\Symfony\Component\Cache\Psr16Cache::class);
    $services->alias(\_PhpScoperf62d28230928\Psr\SimpleCache\CacheInterface::class, \_PhpScoperf62d28230928\Symfony\Component\Cache\Psr16Cache::class);
    $services->set(\_PhpScoperf62d28230928\Symfony\Component\Cache\Adapter\FilesystemAdapter::class)->args(['$namespace' => '%cache_namespace%', '$defaultLifetime' => 0, '$directory' => '%cache_directory%']);
    $services->alias(\_PhpScoperf62d28230928\Psr\Cache\CacheItemPoolInterface::class, \_PhpScoperf62d28230928\Symfony\Component\Cache\Adapter\FilesystemAdapter::class);
    $services->alias(\_PhpScoperf62d28230928\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class, \_PhpScoperf62d28230928\Symfony\Component\Cache\Adapter\TagAwareAdapter::class);
};
