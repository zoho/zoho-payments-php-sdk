<?php

declare(strict_types=1);

namespace Zoho\Payments\Model;

/**
 * @template T
 * @implements \IteratorAggregate<int, T>
 */
final class ListResponse implements \IteratorAggregate, \Countable
{
    /** @var list<T> */
    public readonly array $data;
    public readonly PageContext $pageContext;

    /** @param list<T> $data */
    public function __construct(array $data, PageContext $pageContext)
    {
        $this->data = $data;
        $this->pageContext = $pageContext;
    }

    /** @return \ArrayIterator<int, T> */
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->data);
    }

    public function count(): int
    {
        return count($this->data);
    }
}
