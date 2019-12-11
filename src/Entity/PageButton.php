<?php

namespace App\Entity;

class PageButton
{
    private string $text;
    private ?PageLink $link;

    public function __construct(string $text, ?PageLink $link)
    {
        $this->text = $text;
        $this->link = $link;
    }

    public function getLink(): ?PageLink
    {
        return $this->link;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
