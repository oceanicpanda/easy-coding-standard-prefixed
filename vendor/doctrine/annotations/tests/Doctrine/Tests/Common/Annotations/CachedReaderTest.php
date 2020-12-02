<?php

namespace _PhpScoperf62d28230928\Doctrine\Tests\Common\Annotations;

use _PhpScoperf62d28230928\Doctrine\Tests\Common\Annotations\Fixtures\Annotation\Route;
use _PhpScoperf62d28230928\Doctrine\Common\Annotations\AnnotationReader;
use _PhpScoperf62d28230928\Doctrine\Common\Annotations\CachedReader;
use _PhpScoperf62d28230928\Doctrine\Common\Cache\ArrayCache;
class CachedReaderTest extends \_PhpScoperf62d28230928\Doctrine\Tests\Common\Annotations\AbstractReaderTest
{
    private $cache;
    public function testIgnoresStaleCache()
    {
        $file = __DIR__ . '/Fixtures/Controller.php';
        \touch($file);
        $name = '_PhpScoperf62d28230928\\Doctrine\\Tests\\Common\\Annotations\\Fixtures\\Controller';
        $cacheKey = $name . '@[Annot]';
        $cache = $this->getMock('_PhpScoperf62d28230928\\Doctrine\\Common\\Cache\\Cache');
        $cache->expects($this->at(0))->method('fetch')->with($this->equalTo($cacheKey))->will($this->returnValue(array()));
        $cache->expects($this->at(1))->method('fetch')->with($this->equalTo('[C]' . $cacheKey))->will($this->returnValue(\time() - 10));
        $cache->expects($this->at(2))->method('save')->with($this->equalTo($cacheKey));
        $cache->expects($this->at(3))->method('save')->with($this->equalTo('[C]' . $cacheKey));
        $reader = new \_PhpScoperf62d28230928\Doctrine\Common\Annotations\CachedReader(new \_PhpScoperf62d28230928\Doctrine\Common\Annotations\AnnotationReader(), $cache, \true);
        $route = new \_PhpScoperf62d28230928\Doctrine\Tests\Common\Annotations\Fixtures\Annotation\Route();
        $route->pattern = '/someprefix';
        $this->assertEquals(array($route), $reader->getClassAnnotations(new \ReflectionClass($name)));
    }
    protected function getReader()
    {
        $this->cache = new \_PhpScoperf62d28230928\Doctrine\Common\Cache\ArrayCache();
        return new \_PhpScoperf62d28230928\Doctrine\Common\Annotations\CachedReader(new \_PhpScoperf62d28230928\Doctrine\Common\Annotations\AnnotationReader(), $this->cache);
    }
}
