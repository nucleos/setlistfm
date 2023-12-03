<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Builder;

use Nucleos\SetlistFm\Builder\CitySearchBuilder;
use PHPUnit\Framework\TestCase;

final class CitySearchBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $builder = CitySearchBuilder::create();

        $expected = [
            'p' => 1,
        ];
        self::assertSame($expected, $builder->getQuery());
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
        self::assertSame($expected, $builder->getQuery());
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
        self::assertSame($expected, $builder->getQuery());
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
        self::assertSame($expected, $builder->getQuery());
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
        self::assertSame($expected, $builder->getQuery());
    }

    public function testPage(): void
    {
        $builder = CitySearchBuilder::create()
            ->page(42)
        ;

        $expected = [
            'p' => 42,
        ];
        self::assertSame($expected, $builder->getQuery());
    }
}
