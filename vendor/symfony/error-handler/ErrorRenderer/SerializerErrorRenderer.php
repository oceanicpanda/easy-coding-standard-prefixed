<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\ErrorHandler\ErrorRenderer;

use _PhpScoper78e1a27e740b\Symfony\Component\ErrorHandler\Exception\FlattenException;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpFoundation\Request;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpFoundation\RequestStack;
use _PhpScoper78e1a27e740b\Symfony\Component\Serializer\Exception\NotEncodableValueException;
use _PhpScoper78e1a27e740b\Symfony\Component\Serializer\SerializerInterface;
/**
 * Formats an exception using Serializer for rendering.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class SerializerErrorRenderer implements \_PhpScoper78e1a27e740b\Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface
{
    private $serializer;
    private $format;
    private $fallbackErrorRenderer;
    private $debug;
    /**
     * @param string|callable(FlattenException) $format The format as a string or a callable that should return it
     *                                                  formats not supported by Request::getMimeTypes() should be given as mime types
     * @param bool|callable                     $debug  The debugging mode as a boolean or a callable that should return it
     */
    public function __construct(SerializerInterface $serializer, $format, \_PhpScoper78e1a27e740b\Symfony\Component\ErrorHandler\ErrorRenderer\ErrorRendererInterface $fallbackErrorRenderer = null, $debug = \false)
    {
        if (!\is_string($format) && !\is_callable($format)) {
            throw new \TypeError(\sprintf('Argument 2 passed to "%s()" must be a string or a callable, "%s" given.', __METHOD__, \get_debug_type($format)));
        }
        if (!\is_bool($debug) && !\is_callable($debug)) {
            throw new \TypeError(\sprintf('Argument 4 passed to "%s()" must be a boolean or a callable, "%s" given.', __METHOD__, \get_debug_type($debug)));
        }
        $this->serializer = $serializer;
        $this->format = $format;
        $this->fallbackErrorRenderer = $fallbackErrorRenderer ?? new \_PhpScoper78e1a27e740b\Symfony\Component\ErrorHandler\ErrorRenderer\HtmlErrorRenderer();
        $this->debug = $debug;
    }
    /**
     * {@inheritdoc}
     */
    public function render(\Throwable $exception) : FlattenException
    {
        $headers = [];
        $debug = \is_bool($this->debug) ? $this->debug : ($this->debug)($exception);
        if ($debug) {
            $headers['X-Debug-Exception'] = \rawurlencode($exception->getMessage());
            $headers['X-Debug-Exception-File'] = \rawurlencode($exception->getFile()) . ':' . $exception->getLine();
        }
        $flattenException = FlattenException::createFromThrowable($exception, null, $headers);
        try {
            $format = \is_string($this->format) ? $this->format : ($this->format)($flattenException);
            $headers = ['Content-Type' => Request::getMimeTypes($format)[0] ?? $format, 'Vary' => 'Accept'];
            return $flattenException->setAsString($this->serializer->serialize($flattenException, $format, ['exception' => $exception, 'debug' => $debug]))->setHeaders($flattenException->getHeaders() + $headers);
        } catch (NotEncodableValueException $e) {
            return $this->fallbackErrorRenderer->render($exception);
        }
    }
    public static function getPreferredFormat(RequestStack $requestStack) : \Closure
    {
        return static function () use($requestStack) {
            if (!($request = $requestStack->getCurrentRequest())) {
                throw new NotEncodableValueException();
            }
            return $request->getPreferredFormat();
        };
    }
}
