<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper7f5523334c1b\Symfony\Component\Cache\Traits;

use _PhpScoper7f5523334c1b\Symfony\Component\Cache\Adapter\AdapterInterface;
use _PhpScoper7f5523334c1b\Symfony\Component\Cache\CacheItem;
use _PhpScoper7f5523334c1b\Symfony\Component\Cache\Exception\InvalidArgumentException;
use _PhpScoper7f5523334c1b\Symfony\Component\VarExporter\VarExporter;
/**
 * @author Titouan Galopin <galopintitouan@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
trait PhpArrayTrait
{
    use ProxyTrait;
    private $file;
    private $keys;
    private $values;
    /**
     * Store an array of cached values.
     *
     * @param array $values The cached values
     */
    public function warmUp(array $values)
    {
        if (\file_exists($this->file)) {
            if (!\is_file($this->file)) {
                throw new \_PhpScoper7f5523334c1b\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache path exists and is not a file: %s.', $this->file));
            }
            if (!\is_writable($this->file)) {
                throw new \_PhpScoper7f5523334c1b\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache file is not writable: %s.', $this->file));
            }
        } else {
            $directory = \dirname($this->file);
            if (!\is_dir($directory) && !@\mkdir($directory, 0777, \true)) {
                throw new \_PhpScoper7f5523334c1b\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache directory does not exist and cannot be created: %s.', $directory));
            }
            if (!\is_writable($directory)) {
                throw new \_PhpScoper7f5523334c1b\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache directory is not writable: %s.', $directory));
            }
        }
        $dumpedValues = '';
        $dumpedMap = [];
        $dump = <<<'EOF'
<?php

// This file has been auto-generated by the Symfony Cache Component.

return [[


EOF;
        foreach ($values as $key => $value) {
            \_PhpScoper7f5523334c1b\Symfony\Component\Cache\CacheItem::validateKey(\is_int($key) ? (string) $key : $key);
            $isStaticValue = \true;
            if (null === $value) {
                $value = "'N;'";
            } elseif (\is_object($value) || \is_array($value)) {
                try {
                    $value = \_PhpScoper7f5523334c1b\Symfony\Component\VarExporter\VarExporter::export($value, $isStaticValue);
                } catch (\Exception $e) {
                    throw new \_PhpScoper7f5523334c1b\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key "%s" has non-serializable %s value.', $key, \is_object($value) ? \get_class($value) : 'array'), 0, $e);
                }
            } elseif (\is_string($value)) {
                // Wrap "N;" in a closure to not confuse it with an encoded `null`
                if ('N;' === $value) {
                    $isStaticValue = \false;
                }
                $value = \var_export($value, \true);
            } elseif (!\is_scalar($value)) {
                throw new \_PhpScoper7f5523334c1b\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Cache key "%s" has non-serializable %s value.', $key, \gettype($value)));
            } else {
                $value = \var_export($value, \true);
            }
            if (!$isStaticValue) {
                $value = \str_replace("\n", "\n    ", $value);
                $value = "static function () {\n    return {$value};\n}";
            }
            $hash = \hash('md5', $value);
            if (null === ($id = $dumpedMap[$hash] ?? null)) {
                $id = $dumpedMap[$hash] = \count($dumpedMap);
                $dumpedValues .= "{$id} => {$value},\n";
            }
            $dump .= \var_export($key, \true) . " => {$id},\n";
        }
        $dump .= "\n], [\n\n{$dumpedValues}\n]];\n";
        $tmpFile = \uniqid($this->file, \true);
        \file_put_contents($tmpFile, $dump);
        @\chmod($tmpFile, 0666 & ~\umask());
        unset($serialized, $value, $dump);
        @\rename($tmpFile, $this->file);
        $this->initialize();
    }
    /**
     * {@inheritdoc}
     *
     * @param string $prefix
     *
     * @return bool
     */
    public function clear()
    {
        $prefix = 0 < \func_num_args() ? (string) \func_get_arg(0) : '';
        $this->keys = $this->values = [];
        $cleared = @\unlink($this->file) || !\file_exists($this->file);
        if ($this->pool instanceof \_PhpScoper7f5523334c1b\Symfony\Component\Cache\Adapter\AdapterInterface) {
            return $this->pool->clear($prefix) && $cleared;
        }
        return $this->pool->clear() && $cleared;
    }
    /**
     * Load the cache file.
     */
    private function initialize()
    {
        if (!\file_exists($this->file)) {
            $this->keys = $this->values = [];
            return;
        }
        $values = (include $this->file) ?: [[], []];
        if (2 !== \count($values) || !isset($values[0], $values[1])) {
            $this->keys = $this->values = [];
        } else {
            list($this->keys, $this->values) = $values;
        }
    }
}
