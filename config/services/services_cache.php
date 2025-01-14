<?php

declare (strict_types=1);
namespace _PhpScoper78e1a27e740b;

use _PhpScoper78e1a27e740b\Psr\Cache\CacheItemPoolInterface;
use _PhpScoper78e1a27e740b\Psr\SimpleCache\CacheInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\Cache\Adapter\FilesystemAdapter;
use _PhpScoper78e1a27e740b\Symfony\Component\Cache\Adapter\TagAwareAdapter;
use _PhpScoper78e1a27e740b\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\Cache\Psr16Cache;
use _PhpScoper78e1a27e740b\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
return static function (ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->autowire()->autoconfigure()->public();
    $services->set(Psr16Cache::class);
    $services->alias(CacheInterface::class, Psr16Cache::class);
    $services->set(FilesystemAdapter::class)->args(['$namespace' => '%cache_namespace%', '$defaultLifetime' => 0, '$directory' => '%cache_directory%']);
    $services->alias(CacheItemPoolInterface::class, FilesystemAdapter::class);
    $services->alias(TagAwareAdapterInterface::class, TagAwareAdapter::class);
};
