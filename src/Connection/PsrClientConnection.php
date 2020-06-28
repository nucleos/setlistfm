<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Connection;

use Exception;
use Nucleos\SetlistFm\Exception\ApiException;
use Nucleos\SetlistFm\Exception\NotFoundException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class PsrClientConnection extends AbstractConnection
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * Initialize client.
     *
     * @param string $uri
     */
    public function __construct(ClientInterface $client, RequestFactoryInterface $requestFactory, string $apiKey, string $uri = null)
    {
        parent::__construct($apiKey, $uri);

        $this->client         = $client;
        $this->requestFactory = $requestFactory;
    }

    public function call(string $method, array $params = [], string $requestMethod = 'GET'): array
    {
        $request = $this->buildRequest($method, $params, $requestMethod);

        try {
            $response = $this->client->sendRequest($request);

            return $this->parseResponse($response);
        } catch (ApiException | NotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ApiException('Technical error occurred.', 500, $e);
        } catch (ClientExceptionInterface $e) {
            throw new ApiException('Technical error occurred.', 500, $e);
        }
    }

    /**
     * @throws ApiException
     * @throws NotFoundException
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $content = $response->getBody()->getContents();
        $array   = json_decode($content, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new ApiException('Server did not reply with a valid response.', $response->getStatusCode());
        }

        if (404 === $response->getStatusCode()) {
            throw new NotFoundException('Server did not find any entity for the request.');
        }

        if ($response->getStatusCode() >= 400) {
            throw new ApiException('Technical error occurred.', $response->getStatusCode());
        }

        return $array;
    }

    private function buildRequest(string $method, array $params, string $requestMethod): RequestInterface
    {
        $data = http_build_query($params);

        return $this->requestFactory->createRequest($requestMethod, $this->getUri().$method.'?'.$data)
            ->withHeader('Accept', 'application/json')
            ->withHeader('x-api-key', $this->getApiKey())
        ;
    }
}
