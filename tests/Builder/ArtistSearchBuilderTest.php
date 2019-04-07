<?php

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\SetlistFm\Tests\Builder;

use Core23\SetlistFm\Builder\ArtistSearchBuilder;
use PHPUnit\Framework\TestCase;

class ArtistSearchBuilderTest extends TestCase
{
    public function testCreate(): void
    {
        $builder = ArtistSearchBuilder::create();

        $expected = [
            'p' => 1,
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testWithTmbid(): void
    {
        $builder = ArtistSearchBuilder::create()
            ->withTmbid(123)
        ;

        $expected = [
            'p'          => 1,
            'artistTmid' => 123,
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testWithMbid(): void
    {
        $builder = ArtistSearchBuilder::create()
            ->withMbid('a466c2a2-6517-42fb-a160-1087c3bafd9f')
        ;

        $expected = [
            'p'          => 1,
            'artistMbid' => 'a466c2a2-6517-42fb-a160-1087c3bafd9f',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testWithName(): void
    {
        $builder = ArtistSearchBuilder::create()
            ->withName('FooBar')
        ;

        $expected = [
            'p'          => 1,
            'artistName' => 'FooBar',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testWithNameOverride(): void
    {
        $builder = ArtistSearchBuilder::create()
            ->withName('FooBar')
            ->withName('BarBaz')
        ;

        $expected = [
            'p'          => 1,
            'artistName' => 'BarBaz',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testSortByRelevance(): void
    {
        $builder = ArtistSearchBuilder::create()
            ->sort('relevance')
        ;

        $expected = [
            'p'    => 1,
            'sort' => 'relevance',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testSortByName(): void
    {
        $builder = ArtistSearchBuilder::create()
            ->sort('sortName')
        ;

        $expected = [
            'p'    => 1,
            'sort' => 'sortName',
        ];
        $this->assertSame($expected, $builder->getQuery());
    }

    public function testPage(): void
    {
        $builder = ArtistSearchBuilder::create()
            ->page(42)
        ;

        $expected = [
            'p' => 42,
        ];
        $this->assertSame($expected, $builder->getQuery());
    }
}
