<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Connection;

use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;
use DateTime;
use Exception;
use Http\Client\Exception as ClientException;
use Http\Client\HttpClient;
use Http\Message\RequestFactory;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class HTTPlugConnection extends AbstractConnection
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * Initialize client.
     *
     * @param HttpClient     $client
     * @param RequestFactory $requestFactory
     * @param string         $apiKey
     * @param string         $uri
     */
    public function __construct(HttpClient $client, RequestFactory $requestFactory, string $apiKey, string $uri = null)
    {
        parent::__construct($apiKey, $uri);

        $this->client         = $client;
        $this->requestFactory = $requestFactory;
    }

    /**
     * {@inheritdoc}
     */
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
        } catch (ClientException $e) {
            throw new ApiException('Technical error occurred.', $e->getCode(), $e);
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws ApiException
     * @throws NotFoundException
     *
     * @return array
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

    /**
     * Builds request parameter.
     *
     * @param array $parameter
     *
     * @return string
     */
    private static function buildParameter(array $parameter): string
    {
        foreach ($parameter as $key => $value) {
            if ($value instanceof DateTime) {
                $params[$key] = self::toDateString($value);
            }
        }

        return http_build_query($parameter);
    }

    /**
     * @param string $method
     * @param array  $params
     * @param string $requestMethod
     *
     * @return RequestInterface
     */
    private function buildRequest(string $method, array $params, string $requestMethod): RequestInterface
    {
        $data = self::buildParameter($params);

        $headers = [
            'Accept'    => 'application/json',
            'x-api-key' => $this->getApiKey(),
        ];

        if ('POST' === $requestMethod) {
            return $this->requestFactory->createRequest($requestMethod, $this->getUri().$method, $headers, $data);
        }

        return $this->requestFactory->createRequest($requestMethod, $this->getUri().$method.'?'.$data, $headers);
    }

    /**
     * Formats a date to a timestamp.
     *
     * @param DateTime|null $date
     *
     * @return string|null
     */
    private static function toDateString(DateTime $date = null): ?string
    {
        if (null === $date) {
            return null;
        }

        return $date->format('d-m-Y');
    }
}
