<?php

namespace App\Entity;

class PageLink
{
    private int $pageNr;

    public function __construct(int $pageNr)
    {
        $this->pageNr = $pageNr;
    }

    public function getPageNr(): int
    {
        return $this->pageNr;
    }
}
