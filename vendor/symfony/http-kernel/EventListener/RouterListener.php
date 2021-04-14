<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\EventListener;

use _PhpScoperd32e35cfad84\Psr\Log\LoggerInterface;
use _PhpScoperd32e35cfad84\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpFoundation\Request;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpFoundation\RequestStack;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpFoundation\Response;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Event\ExceptionEvent;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Event\RequestEvent;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Kernel;
use _PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\KernelEvents;
use _PhpScoperd32e35cfad84\Symfony\Component\Routing\Exception\MethodNotAllowedException;
use _PhpScoperd32e35cfad84\Symfony\Component\Routing\Exception\NoConfigurationException;
use _PhpScoperd32e35cfad84\Symfony\Component\Routing\Exception\ResourceNotFoundException;
use _PhpScoperd32e35cfad84\Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use _PhpScoperd32e35cfad84\Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use _PhpScoperd32e35cfad84\Symfony\Component\Routing\RequestContext;
use _PhpScoperd32e35cfad84\Symfony\Component\Routing\RequestContextAwareInterface;
/**
 * Initializes the context from the request and sets request attributes based on a matching route.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 *
 * @final
 */
class RouterListener implements \_PhpScoperd32e35cfad84\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $matcher;
    private $context;
    private $logger;
    private $requestStack;
    private $projectDir;
    private $debug;
    /**
     * @param UrlMatcherInterface|RequestMatcherInterface $matcher    The Url or Request matcher
     * @param RequestContext|null                         $context    The RequestContext (can be null when $matcher implements RequestContextAwareInterface)
     * @param string                                      $projectDir
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($matcher, \_PhpScoperd32e35cfad84\Symfony\Component\HttpFoundation\RequestStack $requestStack, \_PhpScoperd32e35cfad84\Symfony\Component\Routing\RequestContext $context = null, \_PhpScoperd32e35cfad84\Psr\Log\LoggerInterface $logger = null, string $projectDir = null, bool $debug = \true)
    {
        if (!$matcher instanceof \_PhpScoperd32e35cfad84\Symfony\Component\Routing\Matcher\UrlMatcherInterface && !$matcher instanceof \_PhpScoperd32e35cfad84\Symfony\Component\Routing\Matcher\RequestMatcherInterface) {
            throw new \InvalidArgumentException('Matcher must either implement UrlMatcherInterface or RequestMatcherInterface.');
        }
        if (null === $context && !$matcher instanceof \_PhpScoperd32e35cfad84\Symfony\Component\Routing\RequestContextAwareInterface) {
            throw new \InvalidArgumentException('You must either pass a RequestContext or the matcher must implement RequestContextAwareInterface.');
        }
        $this->matcher = $matcher;
        $this->context = $context ?: $matcher->getContext();
        $this->requestStack = $requestStack;
        $this->logger = $logger;
        $this->projectDir = $projectDir;
        $this->debug = $debug;
    }
    private function setCurrentRequest(\_PhpScoperd32e35cfad84\Symfony\Component\HttpFoundation\Request $request = null)
    {
        if (null !== $request) {
            try {
                $this->context->fromRequest($request);
            } catch (\UnexpectedValueException $e) {
                throw new \_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Exception\BadRequestHttpException($e->getMessage(), $e, $e->getCode());
            }
        }
    }
    /**
     * After a sub-request is done, we need to reset the routing context to the parent request so that the URL generator
     * operates on the correct context again.
     */
    public function onKernelFinishRequest(\_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Event\FinishRequestEvent $event)
    {
        $this->setCurrentRequest($this->requestStack->getParentRequest());
    }
    public function onKernelRequest(\_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Event\RequestEvent $event)
    {
        $request = $event->getRequest();
        $this->setCurrentRequest($request);
        if ($request->attributes->has('_controller')) {
            // routing is already done
            return;
        }
        // add attributes based on the request (routing)
        try {
            // matching a request is more powerful than matching a URL path + context, so try that first
            if ($this->matcher instanceof \_PhpScoperd32e35cfad84\Symfony\Component\Routing\Matcher\RequestMatcherInterface) {
                $parameters = $this->matcher->matchRequest($request);
            } else {
                $parameters = $this->matcher->match($request->getPathInfo());
            }
            if (null !== $this->logger) {
                $this->logger->info('Matched route "{route}".', ['route' => $parameters['_route'] ?? 'n/a', 'route_parameters' => $parameters, 'request_uri' => $request->getUri(), 'method' => $request->getMethod()]);
            }
            $request->attributes->add($parameters);
            unset($parameters['_route'], $parameters['_controller']);
            $request->attributes->set('_route_params', $parameters);
        } catch (\_PhpScoperd32e35cfad84\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
            $message = \sprintf('No route found for "%s %s"', $request->getMethod(), $request->getPathInfo());
            if ($referer = $request->headers->get('referer')) {
                $message .= \sprintf(' (from "%s")', $referer);
            }
            throw new \_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Exception\NotFoundHttpException($message, $e);
        } catch (\_PhpScoperd32e35cfad84\Symfony\Component\Routing\Exception\MethodNotAllowedException $e) {
            $message = \sprintf('No route found for "%s %s": Method Not Allowed (Allow: %s)', $request->getMethod(), $request->getPathInfo(), \implode(', ', $e->getAllowedMethods()));
            throw new \_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException($e->getAllowedMethods(), $message, $e);
        }
    }
    public function onKernelException(\_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Event\ExceptionEvent $event)
    {
        if (!$this->debug || !($e = $event->getThrowable()) instanceof \_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return;
        }
        if ($e->getPrevious() instanceof \_PhpScoperd32e35cfad84\Symfony\Component\Routing\Exception\NoConfigurationException) {
            $event->setResponse($this->createWelcomeResponse());
        }
    }
    public static function getSubscribedEvents() : array
    {
        return [\_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\KernelEvents::REQUEST => [['onKernelRequest', 32]], \_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]], \_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\KernelEvents::EXCEPTION => ['onKernelException', -64]];
    }
    private function createWelcomeResponse() : \_PhpScoperd32e35cfad84\Symfony\Component\HttpFoundation\Response
    {
        $version = \_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Kernel::VERSION;
        $projectDir = \realpath($this->projectDir) . \DIRECTORY_SEPARATOR;
        $docVersion = \substr(\_PhpScoperd32e35cfad84\Symfony\Component\HttpKernel\Kernel::VERSION, 0, 3);
        \ob_start();
        include \dirname(__DIR__) . '/Resources/welcome.html.php';
        return new \_PhpScoperd32e35cfad84\Symfony\Component\HttpFoundation\Response(\ob_get_clean(), \_PhpScoperd32e35cfad84\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND);
    }
}
