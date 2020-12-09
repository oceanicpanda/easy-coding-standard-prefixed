<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper31ba553edf97\Symfony\Component\Cache\Marshaller;

use _PhpScoper31ba553edf97\Symfony\Component\Cache\Exception\CacheException;
/**
 * Serializes/unserializes values using igbinary_serialize() if available, serialize() otherwise.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DefaultMarshaller implements \_PhpScoper31ba553edf97\Symfony\Component\Cache\Marshaller\MarshallerInterface
{
    private $useIgbinarySerialize = \true;
    public function __construct(bool $useIgbinarySerialize = null)
    {
        if (null === $useIgbinarySerialize) {
            $useIgbinarySerialize = \extension_loaded('igbinary') && \PHP_VERSION_ID < 70400;
        } elseif ($useIgbinarySerialize && (!\extension_loaded('igbinary') || \PHP_VERSION_ID >= 70400)) {
            throw new \_PhpScoper31ba553edf97\Symfony\Component\Cache\Exception\CacheException('The "igbinary" PHP extension is not ' . (\PHP_VERSION_ID >= 70400 ? 'compatible with PHP 7.4.' : 'loaded.'));
        }
        $this->useIgbinarySerialize = $useIgbinarySerialize;
    }
    /**
     * {@inheritdoc}
     */
    public function marshall(array $values, ?array &$failed) : array
    {
        $serialized = $failed = [];
        foreach ($values as $id => $value) {
            try {
                if ($this->useIgbinarySerialize) {
                    $serialized[$id] = \igbinary_serialize($value);
                } else {
                    $serialized[$id] = \serialize($value);
                }
            } catch (\Exception $e) {
                $failed[] = $id;
            }
        }
        return $serialized;
    }
    /**
     * {@inheritdoc}
     */
    public function unmarshall(string $value)
    {
        if ('b:0;' === $value) {
            return \false;
        }
        if ('N;' === $value) {
            return null;
        }
        static $igbinaryNull;
        if ($value === ($igbinaryNull ?? ($igbinaryNull = \extension_loaded('igbinary') && \PHP_VERSION_ID < 70400 ? \igbinary_serialize(null) : \false))) {
            return null;
        }
        $unserializeCallbackHandler = \ini_set('unserialize_callback_func', __CLASS__ . '::handleUnserializeCallback');
        try {
            if (':' === ($value[1] ?? ':')) {
                if (\false !== ($value = \unserialize($value))) {
                    return $value;
                }
            } elseif (\false === $igbinaryNull) {
                throw new \RuntimeException('Failed to unserialize values, did you forget to install the "igbinary" extension?');
            } elseif (null !== ($value = \igbinary_unserialize($value))) {
                return $value;
            }
            throw new \DomainException(\error_get_last() ? \error_get_last()['message'] : 'Failed to unserialize values.');
        } catch (\Error $e) {
            throw new \ErrorException($e->getMessage(), $e->getCode(), \E_ERROR, $e->getFile(), $e->getLine());
        } finally {
            \ini_set('unserialize_callback_func', $unserializeCallbackHandler);
        }
    }
    /**
     * @internal
     */
    public static function handleUnserializeCallback($class)
    {
        throw new \DomainException('Class not found: ' . $class);
    }
}
