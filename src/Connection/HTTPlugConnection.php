<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Connection;

use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Exception\NotFoundException;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\ResponseInterface;

final class HTTPlugConnection extends AbstractConnection
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * Initialize client.
     *
     * @param HttpClient     $client
     * @param MessageFactory $messageFactory
     * @param string         $apiKey
     * @param string         $uri
     */
    public function __construct(HttpClient $client, MessageFactory $messageFactory, string $apiKey, string $uri = null)
    {
        parent::__construct($apiKey, $uri);

        $this->client         = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function call(string $method, array $params = array(), string $requestMethod = 'GET'): array
    {
        $data = $this->buildParameter($params);

        $headers = array(
            'Accept'    => 'application/json',
            'x-api-key' => $this->apiKey,
        );

        if ($requestMethod === 'POST') {
            $request = $this->messageFactory->createRequest($requestMethod, $this->uri.$method, $headers, $data);
        } else {
            $request = $this->messageFactory->createRequest($requestMethod, $this->uri.$method.'?'.$data, $headers);
        }

        try {
            $response = $this->client->sendRequest($request);

            // Parse response
            return $this->parseResponse($response);
        } catch (ApiException $e) {
            throw $e;
        } catch (NotFoundException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ApiException('Technical error occurred.', 500, $e);
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     *
     * @throws ApiException
     * @throws NotFoundException
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $content = $response->getBody()->getContents();
        $array   = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException('Server did not reply with a valid response.', $response->getStatusCode());
        }

        if ($response->getStatusCode() == 404) {
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
    private function buildParameter(array $parameter): string
    {
        return http_build_query($parameter);
    }
}
