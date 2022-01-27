<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day18
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day18 extends AbstractSolution
{
    protected array $grid;
    protected int $width;
    protected int $height;
    protected array $neighbours = [[0, -1], [1, -1], [1, 0], [1, 1], [0, 1], [-1, 1], [-1, 0], [-1, -1]];

    protected function init(): void
    {
        $this->grid = array_map(fn($row) => str_split(str_replace(['#', '.'], [1, 0], $row)), $this->getInputLines());
        $this->height = count($this->grid);
        $this->width = count($this->grid[0]);
    }


    protected function solvePart1(): string
    {
        return $this->run();
    }

    protected function solvePart2(): string
    {
        $this->lightCornerLights();
        return $this->run(true);
    }

    protected function run(bool $fixCornerLights = false): int
    {
        for ($i = 0; $i < 100; $i++) {
            $newGrid = [];
            for ($y = 0; $y < $this->height; $y++) {
                for ($x = 0; $x < $this->width; $x++) {
                    $on = 0;
                    foreach ($this->neighbours as $offset) {
                        $on += $this->grid[$y + $offset[1]][$x + $offset[0]] ?? 0;
                        if ($on === 4) break;
                    }
                    if ($this->grid[$y][$x] && $on != 2 && $on != 3) {
                        $newGrid[$y][$x] = 0;
                    } elseif (!$this->grid[$y][$x] && $on == 3) {
                        $newGrid[$y][$x] = 1;
                    } else {
                        $newGrid[$y][$x] = $this->grid[$y][$x];
                    }
                }
            }
            $this->grid = $newGrid;
            if ($fixCornerLights) {
                $this->lightCornerLights();
            }
        }
        return array_sum(array_map(fn($row) => array_sum($row), $this->grid));
    }

    protected function lightCornerLights(): void
    {
        $this->grid[0][0] = 1;
        $this->grid[$this->height -1][0] = 1;
        $this->grid[0][$this->width - 1] = 1;
        $this->grid[$this->height -1][$this->width - 1] = 1;
    }
}
