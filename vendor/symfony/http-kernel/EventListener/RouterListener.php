<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\EventListener;

use _PhpScoper78e1a27e740b\Psr\Log\LoggerInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\EventDispatcher\EventSubscriberInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpFoundation\Request;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpFoundation\RequestStack;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpFoundation\Response;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Event\ExceptionEvent;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Event\RequestEvent;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\Kernel;
use _PhpScoper78e1a27e740b\Symfony\Component\HttpKernel\KernelEvents;
use _PhpScoper78e1a27e740b\Symfony\Component\Routing\Exception\MethodNotAllowedException;
use _PhpScoper78e1a27e740b\Symfony\Component\Routing\Exception\NoConfigurationException;
use _PhpScoper78e1a27e740b\Symfony\Component\Routing\Exception\ResourceNotFoundException;
use _PhpScoper78e1a27e740b\Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use _PhpScoper78e1a27e740b\Symfony\Component\Routing\RequestContext;
use _PhpScoper78e1a27e740b\Symfony\Component\Routing\RequestContextAwareInterface;
/**
 * Initializes the context from the request and sets request attributes based on a matching route.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 *
 * @final
 */
class RouterListener implements EventSubscriberInterface
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
    public function __construct($matcher, RequestStack $requestStack, RequestContext $context = null, LoggerInterface $logger = null, string $projectDir = null, bool $debug = \true)
    {
        if (!$matcher instanceof UrlMatcherInterface && !$matcher instanceof RequestMatcherInterface) {
            throw new \InvalidArgumentException('Matcher must either implement UrlMatcherInterface or RequestMatcherInterface.');
        }
        if (null === $context && !$matcher instanceof RequestContextAwareInterface) {
            throw new \InvalidArgumentException('You must either pass a RequestContext or the matcher must implement RequestContextAwareInterface.');
        }
        $this->matcher = $matcher;
        $this->context = $context ?: $matcher->getContext();
        $this->requestStack = $requestStack;
        $this->logger = $logger;
        $this->projectDir = $projectDir;
        $this->debug = $debug;
    }
    private function setCurrentRequest(Request $request = null)
    {
        if (null !== $request) {
            try {
                $this->context->fromRequest($request);
            } catch (\UnexpectedValueException $e) {
                throw new BadRequestHttpException($e->getMessage(), $e, $e->getCode());
            }
        }
    }
    /**
     * After a sub-request is done, we need to reset the routing context to the parent request so that the URL generator
     * operates on the correct context again.
     */
    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
        $this->setCurrentRequest($this->requestStack->getParentRequest());
    }
    public function onKernelRequest(RequestEvent $event)
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
            if ($this->matcher instanceof RequestMatcherInterface) {
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
        } catch (ResourceNotFoundException $e) {
            $message = \sprintf('No route found for "%s %s"', $request->getMethod(), $request->getPathInfo());
            if ($referer = $request->headers->get('referer')) {
                $message .= \sprintf(' (from "%s")', $referer);
            }
            throw new NotFoundHttpException($message, $e);
        } catch (MethodNotAllowedException $e) {
            $message = \sprintf('No route found for "%s %s": Method Not Allowed (Allow: %s)', $request->getMethod(), $request->getPathInfo(), \implode(', ', $e->getAllowedMethods()));
            throw new MethodNotAllowedHttpException($e->getAllowedMethods(), $message, $e);
        }
    }
    public function onKernelException(ExceptionEvent $event)
    {
        if (!$this->debug || !($e = $event->getThrowable()) instanceof NotFoundHttpException) {
            return;
        }
        if ($e->getPrevious() instanceof NoConfigurationException) {
            $event->setResponse($this->createWelcomeResponse());
        }
    }
    public static function getSubscribedEvents() : array
    {
        return [KernelEvents::REQUEST => [['onKernelRequest', 32]], KernelEvents::FINISH_REQUEST => [['onKernelFinishRequest', 0]], KernelEvents::EXCEPTION => ['onKernelException', -64]];
    }
    private function createWelcomeResponse() : Response
    {
        $version = Kernel::VERSION;
        $projectDir = \realpath($this->projectDir) . \DIRECTORY_SEPARATOR;
        $docVersion = \substr(Kernel::VERSION, 0, 3);
        \ob_start();
        include \dirname(__DIR__) . '/Resources/welcome.html.php';
        return new Response(\ob_get_clean(), Response::HTTP_NOT_FOUND);
    }
}
