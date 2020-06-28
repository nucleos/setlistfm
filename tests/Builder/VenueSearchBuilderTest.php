<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Builder;

use Nucleos\SetlistFm\Builder\VenueSearchBuilder;
use PHPUnit\Framework\TestCase;

final class VenueSearchBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $builder = VenueSearchBuilder::create();

        $expected = [
            'p' => 1,
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithCityId(): void
    {
        $builder = VenueSearchBuilder::create()
            ->withCityId(15)
        ;

        $expected = [
            'p'      => 1,
            'cityId' => 15,
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithName(): void
    {
        $builder = VenueSearchBuilder::create()
            ->withName('Foo')
        ;

        $expected = [
            'p'    => 1,
            'name' => 'Foo',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithCountry(): void
    {
        $builder = VenueSearchBuilder::create()
            ->withCountry('DE')
        ;

        $expected = [
            'p'       => 1,
            'country' => 'DE',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithCity(): void
    {
        $builder = VenueSearchBuilder::create()
            ->withCity('New York')
        ;

        $expected = [
            'p'        => 1,
            'cityName' => 'New York',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithStateCode(): void
    {
        $builder = VenueSearchBuilder::create()
            ->withStateCode('NY')
        ;

        $expected = [
            'p'         => 1,
            'stateCode' => 'NY',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithState(): void
    {
        $builder = VenueSearchBuilder::create()
            ->withState('Lower Saxony')
        ;

        $expected = [
            'p'     => 1,
            'state' => 'Lower Saxony',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testPage(): void
    {
        $builder = VenueSearchBuilder::create()
            ->page(42)
        ;

        $expected = [
            'p' => 42,
        ];
        static::assertSame($expected, $builder->getQuery());
    }
}
