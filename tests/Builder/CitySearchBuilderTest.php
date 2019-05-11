<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Builder;

use Core23\SetlistFm\Builder\CitySearchBuilder;
use PHPUnit\Framework\TestCase;

class CitySearchBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $builder = CitySearchBuilder::create();

        $expected = [
            'p' => 1,
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithState(): void
    {
        $builder = CitySearchBuilder::create()
            ->withState('Lower Saxony')
        ;

        $expected = [
            'p'     => 1,
            'state' => 'Lower Saxony',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithName(): void
    {
        $builder = CitySearchBuilder::create()
            ->withName('Hamburg')
        ;

        $expected = [
            'p'    => 1,
            'name' => 'Hamburg',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithCountry(): void
    {
        $builder = CitySearchBuilder::create()
                ->withCountry('DE')
            ;

        $expected = [
            'p'       => 1,
            'country' => 'DE',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testWithStateCode(): void
    {
        $builder = CitySearchBuilder::create()
            ->withStateCode('NY')
        ;

        $expected = [
            'p'         => 1,
            'stateCode' => 'NY',
        ];
        static::assertSame($expected, $builder->getQuery());
    }

    public function testPage(): void
    {
        $builder = CitySearchBuilder::create()
            ->page(42)
        ;

        $expected = [
            'p' => 42,
        ];
        static::assertSame($expected, $builder->getQuery());
    }
}
