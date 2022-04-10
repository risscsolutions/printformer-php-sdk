<?php
/**
 * Luca Perna - Webdeveloper
 * Team Dementia
 * luc@rissc.com
 *
 * Date: 10.04.22
 */

namespace Rissc\Printformer\Client;

/**
 * @template T
 */
final class Paginator
{
    /**
     * @param Array<int, T> $data
     * @param PaginationMeta $meta
     * @param ProvidesListing $providesListing
     */
    public function __construct(private array $data, private PaginationMeta $meta, private ProvidesListing $providesListing)
    {
    }

    public function paginate(): \Generator
    {
        for ($page = 1; $page <= $this->meta->lastPage; $page++) {
            yield $page => $this->providesListing->list($page, $this->meta->perPage)->getData();
        }
    }

    /**
     * @return T[]
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function isLast(): bool
    {
        return $this->meta->currentPage === $this->meta->lastPage;
    }

    /**
     * @return Paginator<T>
     */
    public function next(): self
    {
        return $this->providesListing->list($this->meta->currentPage + 1, $this->meta->perPage);
    }

    /**
     * @return Paginator<T>
     */
    public function previous(): self
    {
        return $this->providesListing->list($this->meta->currentPage - 1, $this->meta->perPage);
    }
}
