<?php

namespace App\Service;

use App\Entity\PageButton;

class Pager
{
    /**
     * @param int $page
     * @param int $total
     * @return PageButton[]
     */
    public function pages(int $page, int $total): array
    {
        $carette = new PagerCarette($page, $total);

        return [
            $carette->first(),
            $carette->prev(),
            ...$carette->numbers(),
            $carette->next(),
            $carette->last(),
        ];
    }
}
