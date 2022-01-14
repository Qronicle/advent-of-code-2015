<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day04
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day04 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        $i = 0;
        do {
            $hash = md5($this->rawInput . ++$i);
        } while (substr($hash, 0, 5) !== '00000');
        return $i;
    }

    protected function solvePart2(): string
    {
        $i = 0;
        do {
            $hash = md5($this->rawInput . ++$i);
        } while (substr($hash, 0, 6) !== '000000');
        return $i;
    }
}
