<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Connection;

use Exception;
use Nucleos\SetlistFm\Connection\PsrClientConnection;
use Nucleos\SetlistFm\Exception\ApiException;
use Nucleos\SetlistFm\Tests\Fixtures\ClientException;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class PsrClientConnectionTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var ObjectProphecy<ClientInterface>
     */
    private $client;

    /**
     * @var ObjectProphecy<RequestFactoryInterface>
     */
    private $requestFactory;

    protected function setUp(): void
    {
        $this->client         = $this->prophesize(ClientInterface::class);
        $this->requestFactory = $this->prophesize(RequestFactoryInterface::class);
    }

    public function testSend(): void
    {
        $client = new PsrClientConnection($this->client->reveal(), $this->requestFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);
        $request->withHeader('Accept', 'application/json')
            ->willReturn($request)
        ;
        $request->withHeader('x-api-key', 'my-key')
            ->willReturn($request)
        ;

        $this->requestFactory->createRequest('GET', 'http://api.url/method?foo=bar')
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
        $client = new PsrClientConnection($this->client->reveal(), $this->requestFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);
        $request->withHeader('Accept', 'application/json')
            ->willReturn($request)
        ;
        $request->withHeader('x-api-key', 'my-key')
            ->willReturn($request)
        ;

        $this->requestFactory->createRequest('GET', 'http://api.url/method?active=1&inactive=0')
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
        $client = new PsrClientConnection($this->client->reveal(), $this->requestFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);
        $request->withHeader('Accept', 'application/json')
            ->willReturn($request)
        ;
        $request->withHeader('x-api-key', 'my-key')
            ->willReturn($request)
        ;

        $this->requestFactory->createRequest('GET', 'http://api.url/method?foo%5B0%5D=bar&foo%5B1%5D=baz')
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

        $client = new PsrClientConnection($this->client->reveal(), $this->requestFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);
        $request->withHeader('Accept', 'application/json')
            ->willReturn($request)
        ;
        $request->withHeader('x-api-key', 'my-key')
            ->willReturn($request)
        ;

        $this->requestFactory->createRequest('GET', 'http://api.url/method?foo=bar')
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

        $client = new PsrClientConnection($this->client->reveal(), $this->requestFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);
        $request->withHeader('Accept', 'application/json')
            ->willReturn($request)
        ;
        $request->withHeader('x-api-key', 'my-key')
            ->willReturn($request)
        ;

        $this->requestFactory->createRequest('GET', 'http://api.url/method?foo=bar')
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

        $client = new PsrClientConnection($this->client->reveal(), $this->requestFactory->reveal(), 'my-key', 'http://api.url/');

        $request =  $this->prophesize(RequestInterface::class);
        $request->withHeader('Accept', 'application/json')
            ->willReturn($request)
        ;
        $request->withHeader('x-api-key', 'my-key')
            ->willReturn($request)
        ;

        $this->requestFactory->createRequest('GET', 'http://api.url/method?foo=bar')
            ->willReturn($request)
        ;

        $response =$this->prepareResponse('', 500);

        $this->client->sendRequest($request)
            ->willReturn($response)
        ;

        $client->call('method', ['foo' => 'bar']);
    }

    /**
     * @return ObjectProphecy<ResponseInterface>
     */
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
