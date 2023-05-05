<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 05.05.23
 */

namespace Rissc\Printformer\Tests\Client;

use PHPUnit\Framework\TestCase;
use Rissc\Printformer\Client\PaginationMeta;
use Rissc\Printformer\Client\Paginator;
use Rissc\Printformer\Client\ProvidesListing;

class PaginatorTest extends TestCase
{
    public function testPagination(): void
    {
        $providesListing = $this->getMockBuilder(ProvidesListing::class)->getMock();
        $providesListing->expects(static::exactly(2))
            ->method('list')
            ->withConsecutive([static::equalTo(1), static::equalTo(25)], [static::equalTo(2), static::equalTo(25)])
            ->willReturn(new Paginator([], new PaginationMeta(1, 2, 25, 26), $providesListing));

        $paginator = new Paginator([], new PaginationMeta(1, 2, 25, 26), $providesListing);

        $generator = $paginator->paginate();
        $i = 1;
        foreach ($generator as $page => $entries) {
            static::assertEquals($i++, $page);
        }
    }

    public function testNext(): void
    {
        $providesListing = $this->getMockBuilder(ProvidesListing::class)->getMock();
        $providesListing->expects(static::once())
            ->method('list')
            ->with(static::equalTo(2), static::equalTo(25))
            ->willReturn(new Paginator([], new PaginationMeta(2, 2, 25, 26), $providesListing));

        $paginator = new Paginator([], new PaginationMeta(1, 2, 25, 26), $providesListing);

        $paginator->next();
    }

    public function testPrevious(): void
    {
        $providesListing = $this->getMockBuilder(ProvidesListing::class)->getMock();
        $providesListing->expects(static::once())
            ->method('list')
            ->with(static::equalTo(1), static::equalTo(25))
            ->willReturn(new Paginator([], new PaginationMeta(1, 2, 25, 26), $providesListing));

        $paginator = new Paginator([], new PaginationMeta(2, 2, 25, 26), $providesListing);

        $paginator->previous();
    }
}
