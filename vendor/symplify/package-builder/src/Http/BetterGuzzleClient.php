<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Http;

use _PhpScopera88a8b9f064a\GuzzleHttp\ClientInterface;
use _PhpScopera88a8b9f064a\GuzzleHttp\Exception\BadResponseException;
use _PhpScopera88a8b9f064a\GuzzleHttp\Psr7\Request;
use _PhpScopera88a8b9f064a\Nette\Utils\Json;
use _PhpScopera88a8b9f064a\Nette\Utils\JsonException;
use _PhpScopera88a8b9f064a\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\_PhpScopera88a8b9f064a\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \_PhpScopera88a8b9f064a\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \_PhpScopera88a8b9f064a\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \_PhpScopera88a8b9f064a\Nette\Utils\Json::decode($content, \_PhpScopera88a8b9f064a\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\_PhpScopera88a8b9f064a\Nette\Utils\JsonException $jsonException) {
            throw new \_PhpScopera88a8b9f064a\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\_PhpScopera88a8b9f064a\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
