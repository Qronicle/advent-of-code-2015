<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day12
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day12 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        $input = json_decode($this->rawInput, true);
        return $this->recursiveSum($input);
    }

    protected function solvePart2(): string
    {
        $input = json_decode($this->rawInput, true);
        return $this->recursiveSum($input, true);
    }

    protected function recursiveSum(array $items, bool $red = false): int
    {
        if ($red && key($items) !== 0 && in_array('red', $items, true)) {
             return 0;
        }
        $sum = 0;
        foreach ($items as $item) {
            if (is_array($item)) {
                $sum += $this->recursiveSum($item, $red);
            } elseif (is_numeric($item)) {
                $sum += $item;
            }
        }
        return $sum;
    }
}
