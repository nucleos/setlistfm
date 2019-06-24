<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Connection;

use Core23\SetlistFm\Connection\ConnectionInterface;
use Core23\SetlistFm\Connection\HTTPlugConnection;
use Core23\SetlistFm\Exception\ApiException;
use Core23\SetlistFm\Tests\Fixtures\ClientException;
use Exception;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class HTTPlugConnectionTest extends TestCase
{
    private $client;

    private $messageFactory;

    protected function setUp()
    {
        $this->client         = $this->prophesize(HttpClient::class);
        $this->messageFactory = $this->prophesize(MessageFactory::class);
    }

    public function testItIsInstantiable(): void
    {
        $client = new HTTPlugConnection($this->client->reveal(), $this->messageFactory->reveal(), 'my-key', 'http://api.url/');

        static::assertInstanceOf(ConnectionInterface::class, $client);
    }

    public function testSend(): void
    {
        $client = new HTTPlugConnection($this->client->reveal(), $this->messageFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);

        $this->messageFactory->createRequest('GET', 'http://api.url/method?foo=bar', [
            'Accept'    => 'application/json',
            'x-api-key' => 'my-key',
        ])
            ->willReturn($request)
        ;

        $response =$this->prepareResponse('{"data": "test"}');

        $this->client->sendRequest($request)
            ->willReturn($response)
        ;

        static::assertSame(['data' => 'test'], $client->call('method', ['foo' => 'bar']));
    }

    public function testSendWithBooleanParameter(): void
    {
        $client = new HTTPlugConnection($this->client->reveal(), $this->messageFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);

        $this->messageFactory->createRequest('GET', 'http://api.url/method?active=1&inactive=0', [
            'Accept'    => 'application/json',
            'x-api-key' => 'my-key',
        ])
            ->willReturn($request)
        ;

        $response =$this->prepareResponse('{"data": "test"}');

        $this->client->sendRequest($request)
            ->willReturn($response)
        ;

        static::assertSame(['data' => 'test'], $client->call('method', ['active' => true, 'inactive' => false]));
    }

    public function testSendWithArrayParameter(): void
    {
        $client = new HTTPlugConnection($this->client->reveal(), $this->messageFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);

        $this->messageFactory->createRequest('GET', 'http://api.url/method?foo%5B0%5D=bar&foo%5B1%5D=baz', [
            'Accept'    => 'application/json',
            'x-api-key' => 'my-key',
        ])
            ->willReturn($request)
        ;

        $response =$this->prepareResponse('{"data": "test"}');

        $this->client->sendRequest($request)
            ->willReturn($response)
        ;

        static::assertSame(['data' => 'test'], $client->call('method', ['foo' => ['bar', 'baz']]));
    }

    public function testSendWithException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Technical error occurred.');

        $client = new HTTPlugConnection($this->client->reveal(), $this->messageFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);

        $this->messageFactory->createRequest('GET', 'http://api.url/method?foo=bar', [
            'Accept'    => 'application/json',
            'x-api-key' => 'my-key',
        ])
            ->willReturn($request)
        ;

        $this->client->sendRequest($request)
            ->willThrow(Exception::class)
        ;

        $client->call('method', ['foo' => 'bar']);
    }

    public function testSendWithClientException(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Technical error occurred.');

        $client = new HTTPlugConnection($this->client->reveal(), $this->messageFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);

        $this->messageFactory->createRequest('GET', 'http://api.url/method?foo=bar', [
            'Accept'    => 'application/json',
            'x-api-key' => 'my-key',
        ])
            ->willReturn($request)
        ;

        $this->client->sendRequest($request)
            ->willThrow(ClientException::class)
        ;

        $client->call('method', ['foo' => 'bar']);
    }

    public function testSendWithInvalidResponse(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Server did not reply with a valid response.');

        $client = new HTTPlugConnection($this->client->reveal(), $this->messageFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);

        $this->messageFactory->createRequest('GET', 'http://api.url/method?foo=bar', [
            'Accept'    => 'application/json',
            'x-api-key' => 'my-key',
        ])
            ->willReturn($request)
        ;

        $response =$this->prepareResponse('', 500);

        $this->client->sendRequest($request)
            ->willReturn($response)
        ;

        $client->call('method', ['foo' => 'bar']);
    }

    private function prepareResponse(string $content, int $code = 200): ObjectProphecy
    {
        $stream = $this->prophesize(StreamInterface::class);
        $stream->getContents()
            ->willReturn($content)
        ;

        $response = $this->prophesize(ResponseInterface::class);
        $response->getBody()
            ->willReturn($stream)
        ;
        $response->getStatusCode()
            ->willReturn($code)
        ;

        return $response;
    }
}
