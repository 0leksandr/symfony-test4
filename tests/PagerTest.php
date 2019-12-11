<?php

namespace App\Tests;

use App\Entity\PageButton;
use App\Entity\PageLink;
use App\Service\Pager;
use PHPUnit\Framework\TestCase;

class PagerTest extends TestCase
{
    private Pager $SUT;

    public function setUp(): void
    {
        $this->SUT = new Pager();
    }

    /**
     * @dataProvider dataProvider
     * @param int $current
     * @param int $total
     * @param string[]|string[][] $expected
     */
    public function test(int $current, int $total, array $expected): void
    {
        $expected = array_map(
            fn ($a) => is_array($a) ?
                new PageButton($a[0], new PageLink($a[1])) :
                new PageButton($a, null),
            $expected
        );
        $this->assertEquals($expected, $this->SUT->pages($current, $total));
    }

    /**
     * @return array[]
     */
    public function dataProvider(): array
    {
        return [
            [
                1,
                1,
                [
                    '<<',
                    '<',
                    '1',
                    '>',
                    '>>',
                ],
            ],
            [
                1,
                2,
                [
                    '<<',
                    '<',
                    '1',
                    ['2', 2],
                    ['>', 2],
                    ['>>', 2],
                ],
            ],
            [
                2,
                2,
                [
                    ['<<', 1],
                    ['<', 1],
                    ['1', 1],
                    '2',
                    '>',
                    '>>',
                ],
            ],
            [
                1,
                3,
                [
                    '<<',
                    '<',
                    '1',
                    ['2', 2],
                    ['3', 3],
                    ['>', 2],
                    ['>>', 3],
                ],
            ],
            [
                2,
                3,
                [
                    ['<<', 1],
                    ['<', 1],
                    ['1', 1],
                    '2',
                    ['3', 3],
                    ['>', 3],
                    ['>>', 3],
                ],
            ],
            [
                3,
                3,
                [
                    ['<<', 1],
                    ['<', 2],
                    ['1', 1],
                    ['2', 2],
                    '3',
                    '>',
                    '>>',
                ],
            ],
            [
                1,
                6,
                [
                    '<<',
                    '<',
                    '1',
                    ['2', 2],
                    ['3', 3],
                    ['4', 4],
                    ['5', 5],
                    ['>', 2],
                    ['>>', 6],
                ],
            ],
            [
                2,
                18,
                [
                    ['<<', 1],
                    ['<', 1],
                    ['1', 1],
                    '2',
                    ['3', 3],
                    ['4', 4],
                    ['5', 5],
                    ['>', 3],
                    ['>>', 18],
                ],
            ],
        ];
    }
}
