<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoperf62d28230928\Symfony\Component\HttpFoundation\Test\Constraint;

use _PhpScoperf62d28230928\PHPUnit\Framework\Constraint\Constraint;
use _PhpScoperf62d28230928\Symfony\Component\HttpFoundation\Cookie;
use _PhpScoperf62d28230928\Symfony\Component\HttpFoundation\Response;
final class ResponseCookieValueSame extends \_PhpScoperf62d28230928\PHPUnit\Framework\Constraint\Constraint
{
    private $name;
    private $value;
    private $path;
    private $domain;
    public function __construct(string $name, string $value, string $path = '/', string $domain = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->path = $path;
        $this->domain = $domain;
    }
    /**
     * {@inheritdoc}
     */
    public function toString() : string
    {
        $str = \sprintf('has cookie "%s"', $this->name);
        if ('/' !== $this->path) {
            $str .= \sprintf(' with path "%s"', $this->path);
        }
        if ($this->domain) {
            $str .= \sprintf(' for domain "%s"', $this->domain);
        }
        $str .= \sprintf(' with value "%s"', $this->value);
        return $str;
    }
    /**
     * @param Response $response
     *
     * {@inheritdoc}
     */
    protected function matches($response) : bool
    {
        $cookie = $this->getCookie($response);
        if (!$cookie) {
            return \false;
        }
        return $this->value === $cookie->getValue();
    }
    /**
     * @param Response $response
     *
     * {@inheritdoc}
     */
    protected function failureDescription($response) : string
    {
        return 'the Response ' . $this->toString();
    }
    protected function getCookie(\_PhpScoperf62d28230928\Symfony\Component\HttpFoundation\Response $response) : ?\_PhpScoperf62d28230928\Symfony\Component\HttpFoundation\Cookie
    {
        $cookies = $response->headers->getCookies();
        $filteredCookies = \array_filter($cookies, function (\_PhpScoperf62d28230928\Symfony\Component\HttpFoundation\Cookie $cookie) {
            return $cookie->getName() === $this->name && $cookie->getPath() === $this->path && $cookie->getDomain() === $this->domain;
        });
        return \reset($filteredCookies) ?: null;
    }
}
