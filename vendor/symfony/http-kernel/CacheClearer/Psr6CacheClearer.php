<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\CacheClearer;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Psr6CacheClearer implements \_PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface
{
    private $pools = [];
    public function __construct(array $pools = [])
    {
        $this->pools = $pools;
    }
    public function hasPool(string $name)
    {
        return isset($this->pools[$name]);
    }
    public function getPool(string $name)
    {
        if (!$this->hasPool($name)) {
            throw new \InvalidArgumentException(\sprintf('Cache pool not found: "%s".', $name));
        }
        return $this->pools[$name];
    }
    public function clearPool(string $name)
    {
        if (!isset($this->pools[$name])) {
            throw new \InvalidArgumentException(\sprintf('Cache pool not found: "%s".', $name));
        }
        return $this->pools[$name]->clear();
    }
    /**
     * {@inheritdoc}
     */
    public function clear(string $cacheDir)
    {
        foreach ($this->pools as $pool) {
            $pool->clear();
        }
    }
}
