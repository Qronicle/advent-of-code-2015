<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day01
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day01 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        $numChars = strlen($this->rawInput);
        $numDown = count(array_filter(str_split($this->rawInput), fn ($val) => $val == ')'));
        return $numChars - $numDown * 2;
    }

    protected function solvePart2(): string
    {
        $numChars = strlen($this->rawInput);
        $floor = 0;
        for ($i = 0; $i < $numChars; $i++) {
            $floor += $this->rawInput[$i] == ')' ? -1 : 1;
            if ($floor < 0) {
                return $i + 1;
            }
        }
        return -1;
    }
}
