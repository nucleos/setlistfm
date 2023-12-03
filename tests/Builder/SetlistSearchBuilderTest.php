<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nucleos\SetlistFm\Tests\Builder;

use DateTime;
use Nucleos\SetlistFm\Builder\SetlistSearchBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class SetlistSearchBuilderTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        date_default_timezone_set('UTC');
    }

    public function testCreate(): void
    {
        $builder = SetlistSearchBuilder::create();

        $expected = [
            'p' => 1,
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithVenueName(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withVenueName('Live in New York')
        ;

        $expected = [
            'p'         => 1,
            'venueName' => 'Live in New York',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithVenueId(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withVenueId('13')
        ;

        $expected = [
            'p'       => 1,
            'venueId' => '13',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithLastUpdated(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withLastUpdated(new DateTime('2016-10-12 23:12:00'))
        ;

        $expected = [
            'p'           => 1,
            'lastUpdated' => '20161012231200',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithDate(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withDate(new DateTime('2016-10-12'))
        ;

        $expected = [
            'p'    => 1,
            'date' => '12-10-2016',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithYear(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withYear(2018)
        ;

        $expected = [
            'p'    => 1,
            'year' => 2018,
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithTourName(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withTourName('My Tour')
        ;

        $expected = [
            'p'        => 1,
            'tourName' => 'My Tour',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithArtistName(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withArtistName('Slipknot')
        ;

        $expected = [
            'p'          => 1,
            'artistName' => 'Slipknot',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithArtistMbid(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withArtistMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
        ;

        $expected = [
            'p'          => 1,
            'artistMbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithArtistTmbid(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withArtistTmbid(15515)
        ;

        $expected = [
            'p'           => 1,
            'artistTmbid' => 15515,
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithCity(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withCity('Hamburg')
        ;

        $expected = [
            'p'        => 1,
            'cityName' => 'Hamburg',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithCityId(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withCityId(15)
        ;

        $expected = [
            'p'      => 1,
            'cityId' => 15,
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithCountryCode(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withCountryCode('DE')
        ;

        $expected = [
            'p'           => 1,
            'countryCode' => 'DE',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithStateCode(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withStateCode('NY')
        ;

        $expected = [
            'p'         => 1,
            'stateCode' => 'NY',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testWithState(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->withState('Lower Saxony')
        ;

        $expected = [
            'p'     => 1,
            'state' => 'Lower Saxony',
        ];
        self::assertSame($expected, $builder->getQuery());
    }

    public function testPage(): void
    {
        $builder = SetlistSearchBuilder::create()
            ->page(42)
        ;

        $expected = [
            'p' => 42,
        ];
        self::assertSame($expected, $builder->getQuery());
    }
}
