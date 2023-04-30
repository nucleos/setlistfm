<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Connection;

use Closure;
use Exception;
use Nucleos\SetlistFm\Connection\PsrClientConnection;
use Nucleos\SetlistFm\Exception\ApiException;
use Nucleos\SetlistFm\Tests\Fixtures\ClientException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final class PsrClientConnectionTest extends TestCase
{
    /**
     * @var ClientInterface&MockObject
     */
    private ClientInterface $client;

    /**
     * @var MockObject&RequestFactoryInterface
     */
    private RequestFactoryInterface $requestFactory;

    protected function setUp(): void
    {
        $this->client         = $this->createMock(ClientInterface::class);
        $this->requestFactory = $this->createMock(RequestFactoryInterface::class);
    }

    public function testSend(): void
    {
        $client = new PsrClientConnection($this->client, $this->requestFactory, 'my-key', 'http://api.url/');

        $request =  $this->createMock(RequestInterface::class);
        $request->expects($matcher = static::exactly(2))->method('withHeader')
            ->willReturnCallback($this->withParameter($matcher, [
                ['Accept', 'application/json'],
                ['x-api-key', 'my-key'],
            ]))
            ->willReturn($request)
        ;

        $this->requestFactory->method('createRequest')->with('GET', 'http://api.url/method?foo=bar')
            ->willReturn($request)
        ;

        $response =$this->prepareResponse('{"data": "test"}');

        $this->client->method('sendRequest')->with($request)
            ->willReturn($response)
        ;

        static::assertSame(['data' => 'test'], $client->call('method', ['foo' => 'bar']));
    }

    public function testSendWithBooleanParameter(): void
    {
        $client = new PsrClientConnection($this->client, $this->requestFactory, 'my-key', 'http://api.url/');

        $request =  $this->createMock(RequestInterface::class);
        $request->expects($matcher = static::exactly(2))->method('withHeader')
            ->willReturnCallback($this->withParameter($matcher, [
                ['Accept', 'application/json'],
                ['x-api-key', 'my-key'],
            ]))
            ->willReturn($request)
        ;

        $this->requestFactory->method('createRequest')->with('GET', 'http://api.url/method?active=1&inactive=0')
            ->willReturn($request)
        ;

        $response = $this->prepareResponse('{"data": "test"}');

        $this->client->method('sendRequest')->with($request)
            ->willReturn($response)
        ;

        static::assertSame(['data' => 'test'], $client->call('method', ['active' => true, 'inactive' => false]));
    }

    public function testSendWithArrayParameter(): void
    {
        $client = new PsrClientConnection($this->client, $this->requestFactory, 'my-key', 'http://api.url/');

        $request =  $this->createMock(RequestInterface::class);
        $request->expects($matcher = static::exactly(2))->method('withHeader')
            ->willReturnCallback($this->withParameter($matcher, [
                ['Accept', 'application/json'],
                ['x-api-key', 'my-key'],
            ]))
            ->willReturn($request)
        ;

        $this->requestFactory->method('createRequest')->with('GET', 'http://api.url/method?foo%5B0%5D=bar&foo%5B1%5D=baz')
            ->willReturn($request)
        ;

        $response = $this->prepareResponse('{"data": "test"}');

        $this->client->method('sendRequest')->with($request)
            ->willReturn($response)
        ;

        static::assertSame(['data' => 'test'], $client->call('method', ['foo' => ['bar', 'baz']]));
    }

    public function testSendWithException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Technical error occurred.');

        $client = new PsrClientConnection($this->client, $this->requestFactory, 'my-key', 'http://api.url/');

        $request =  $this->createMock(RequestInterface::class);
        $request->expects($matcher = static::exactly(2))->method('withHeader')
            ->willReturnCallback($this->withParameter($matcher, [
                ['Accept', 'application/json'],
                ['x-api-key', 'my-key'],
            ]))
            ->willReturn($request)
        ;

        $this->requestFactory->method('createRequest')->with('GET', 'http://api.url/method?foo=bar')
            ->willReturn($request)
        ;

        $this->client->method('sendRequest')->with($request)
            ->willThrowException(new Exception())
        ;

        $client->call('method', ['foo' => 'bar']);
    }

    public function testSendWithClientException(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Technical error occurred.');

        $client = new PsrClientConnection($this->client, $this->requestFactory, 'my-key', 'http://api.url/');

        $request =  $this->createMock(RequestInterface::class);
        $request->expects($matcher = static::exactly(2))->method('withHeader')
            ->willReturnCallback($this->withParameter($matcher, [
                ['Accept', 'application/json'],
                ['x-api-key', 'my-key'],
            ]))
            ->willReturn($request)
        ;

        $this->requestFactory->method('createRequest')->with('GET', 'http://api.url/method?foo=bar')
            ->willReturn($request)
        ;

        $this->client->method('sendRequest')->with($request)
            ->willThrowException(new ClientException())
        ;

        $client->call('method', ['foo' => 'bar']);
    }

    public function testSendWithInvalidResponse(): void
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage('Server did not reply with a valid response.');

        $client = new PsrClientConnection($this->client, $this->requestFactory, 'my-key', 'http://api.url/');

        $request =  $this->createMock(RequestInterface::class);
        $request->expects($matcher = static::exactly(2))->method('withHeader')
            ->willReturnCallback($this->withParameter($matcher, [
                ['Accept', 'application/json'],
                ['x-api-key', 'my-key'],
            ]))
            ->willReturn($request)
        ;

        $this->requestFactory->method('createRequest')->with('GET', 'http://api.url/method?foo=bar')
            ->willReturn($request)
        ;

        $response = $this->prepareResponse('', 500);

        $this->client->method('sendRequest')->with($request)
            ->willReturn($response)
        ;

        $client->call('method', ['foo' => 'bar']);
    }

    /**
     * @return MockObject&ResponseInterface
     */
    private function prepareResponse(string $content, int $code = 200): ResponseInterface
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('getContents')
            ->willReturn($content)
        ;

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')
            ->willReturn($stream)
        ;
        $response->method('getStatusCode')
            ->willReturn($code)
        ;

        return $response;
    }

    /**
     * @param array<array-key, mixed[]> $parameters
     */
    private function withParameter(InvokedCount $matcher, array $parameters): Closure
    {
        return static function () use ($matcher, $parameters): void {
            /** @psalm-suppress InternalMethod */
            $callNumber = $matcher->numberOfInvocations();

            self::assertSame($parameters[$callNumber-1], \func_get_args(), sprintf('Call %s', $callNumber));
        };
    }
}
