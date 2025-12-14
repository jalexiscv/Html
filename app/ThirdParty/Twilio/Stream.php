<?php

namespace Twilio;

use Iterator;

class Stream implements Iterator
{
    public $page;
    public $firstPage;
    public $limit;
    public $currentRecord;
    public $pageLimit;
    public $currentPage;

    public function __construct(Page $page, $limit, $pageLimit)
    {
        $this->page = $page;
        $this->firstPage = $page;
        $this->limit = $limit;
        $this->currentRecord = 1;
        $this->pageLimit = $pageLimit;
        $this->currentPage = 1;
    }

    public function current()
    {
        return $this->page->current();
    }

    public function next(): void
    {
        $this->page->next();
        $this->currentRecord++;
        if ($this->overLimit()) {
            return;
        }
        if (!$this->page->valid()) {
            if ($this->overPageLimit()) {
                return;
            }
            $this->page = $this->page->nextPage();
            $this->currentPage++;
        }
    }

    public function key()
    {
        return $this->currentRecord;
    }

    public function valid(): bool
    {
        return $this->page && $this->page->valid() && !$this->overLimit() && !$this->overPageLimit();
    }

    public function rewind(): void
    {
        $this->page = $this->firstPage;
        $this->page->rewind();
        $this->currentPage = 1;
        $this->currentRecord = 1;
    }

    protected function overLimit(): bool
    {
        return ($this->limit !== null && $this->limit !== Values::NONE && $this->limit < $this->currentRecord);
    }

    protected function overPageLimit(): bool
    {
        return ($this->pageLimit !== null && $this->pageLimit !== Values::NONE && $this->pageLimit < $this->currentPage);
    }
}