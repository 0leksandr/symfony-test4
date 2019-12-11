<?php

namespace App\Service;

use App\Entity\PageButton;
use App\Entity\PageLink;

class PagerCarette
{
    /** @var int */
    private int $page;
    /** @var int */
    private int $total;

    public function __construct(int $page, int $total)
    {
        $this->page  = $page;
        $this->total = $total;
    }

    public function prev(): PageButton
    {
        if ($this->page === 1) {
            return new PageButton('<', null);
        }
        return new PageButton('<', new PageLink($this->page - 1));
    }

    public function next(): PageButton
    {
        if ($this->page === $this->total) {
            return new PageButton('>', null);
        }
        return new PageButton('>', new PageLink($this->page + 1));
    }

    public function numbers(): array
    {
        $buttons = [];
        foreach (range($this->from(), $this->to()) as $ii) {
            $buttons[] = $this->button($ii, $ii);
        }

        return $buttons;
    }

    public function first(): PageButton
    {
        return $this->button('<<', 1);
    }

    public function last(): PageButton
    {
        return $this->button('>>', $this->total);
    }

    private function from(): int
    {
        return max(1, min($this->page - 2, $this->total - 4));
    }

    private function to(): int
    {
        return min($this->total, max($this->page + 2, 5));
    }

    private function button(string $text, int $page): PageButton
    {
        if ($this->page === $page) {
            return new PageButton($text, null);
        }
        return new PageButton($text, new PageLink($page));
    }
}
