<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day10
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day10 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        return strlen($this->play($this->rawInput, 40));
    }

    protected function solvePart2(): string
    {
        return strlen($this->play($this->rawInput, 50));
    }

    protected function play(string $input, int $turns = 1)
    {
        for ($turn = 0; $turn < $turns; $turn++) {
            $output = '';
            for ($i = 0; $i < strlen($input); $i++) {
                $number = $input[$i];
                $count = 1;
                while ($number == ($input[$i + 1] ?? '')) {
                    $i++;
                    $count++;
                }
                $output .= $count . $number;
            }
            $input = $output;
        }
        return $input;
    }
}
