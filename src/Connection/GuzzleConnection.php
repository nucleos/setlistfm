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
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;

final class GuzzleConnection extends AbstractConnection
{
    /**
     * @var Client
     */
    private $client;

    /**
     * {@inheritdoc}
     */
    public function call(string $method, array $params = array(), string $requestMethod = 'GET'): array
    {
        $data  = $this->buildParameter($params);

        try {
            if ($requestMethod == 'POST') {
                $response = $this->getClient()->request($requestMethod, $method.'.json', array(
                    'body' => $data,
                ));
            } else {
                $response = $this->getClient()->request($requestMethod, $method.'.json?'.$data);
            }

            // Parse response
            return $this->parseResponse($response);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            if (null === $response) {
                throw new ApiException('Client exception with empty response occurred.', 500);
            }

            return $this->parseResponse($response);
        } catch (ApiException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new ApiException('Technical error occurred.', 500);
        }
    }

    /**
     * @return Client
     */
    protected function getClient(): Client
    {
        if (null === $this->client) {
            $this->client = new Client(array('base_uri' => $this->uri));
        }

        return $this->client;
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

        if (json_last_error() == JSON_ERROR_NONE) {
            return $array;
        }

        if (static::NOT_FOUND_MESSAGE === $content) {
            throw new NotFoundException();
        }

        throw new ApiException($content, $response->getStatusCode());
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
