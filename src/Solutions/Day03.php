<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day03
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day03 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        $presentPerHouse = ['0,0' => 1];
        $directions = ['<' => [-1, 0], '>' => [1, 0], '^' => [0, -1], 'v' => [0, 1]];
        $x = 0;
        $y = 0;
        $routeLen = strlen($this->rawInput);
        for ($i = 0; $i < $routeLen; $i++) {
            $x += $directions[$this->rawInput[$i]][0];
            $y += $directions[$this->rawInput[$i]][1];
            $key = "$x,$y";
            $presentPerHouse[$key] = isset($presentPerHouse[$key]) ? $presentPerHouse[$key] + 1 : 1;
        }
        return count($presentPerHouse);
    }

    protected function solvePart2(): string
    {
        $presentPerHouse = ['0,0' => 1];
        $directions = ['<' => [-1, 0], '>' => [1, 0], '^' => [0, -1], 'v' => [0, 1]];
        $positions = [[0, 0], [0, 0]];
        $routeLen = strlen($this->rawInput);
        for ($i = 0; $i < $routeLen; $i++) {
            $pos = $i % 2;
            $positions[$pos][0] += $directions[$this->rawInput[$i]][0];
            $positions[$pos][1] += $directions[$this->rawInput[$i]][1];
            $key = implode(',', $positions[$pos]);
            $presentPerHouse[$key] = isset($presentPerHouse[$key]) ? $presentPerHouse[$key] + 1 : 1;
        }
        return count($presentPerHouse);
    }
}
