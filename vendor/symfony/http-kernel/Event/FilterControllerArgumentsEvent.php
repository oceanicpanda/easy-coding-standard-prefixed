<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper0d0ee1ba46d4\Symfony\Component\HttpKernel\Event;

use _PhpScoper0d0ee1ba46d4\Symfony\Component\HttpFoundation\Request;
use _PhpScoper0d0ee1ba46d4\Symfony\Component\HttpKernel\HttpKernelInterface;
/**
 * @deprecated since Symfony 4.3, use ControllerArgumentsEvent instead
 */
class FilterControllerArgumentsEvent extends \_PhpScoper0d0ee1ba46d4\Symfony\Component\HttpKernel\Event\FilterControllerEvent
{
    private $arguments;
    public function __construct(\_PhpScoper0d0ee1ba46d4\Symfony\Component\HttpKernel\HttpKernelInterface $kernel, callable $controller, array $arguments, \_PhpScoper0d0ee1ba46d4\Symfony\Component\HttpFoundation\Request $request, ?int $requestType)
    {
        parent::__construct($kernel, $controller, $request, $requestType);
        $this->arguments = $arguments;
    }
    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }
}