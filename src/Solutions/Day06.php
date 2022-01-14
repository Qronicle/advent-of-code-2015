<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day06
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day06 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        $grid = array_fill(0, 1000, array_fill(0, 1000, 0));
        foreach ($this->getInputLines() as $instruction) {
            preg_match('/^([a-z ]+) ([0-9]+),([0-9]+) through ([0-9]+),([0-9]+)$/', $instruction, $matches);
            array_shift($matches);
            list($action, $x1, $y1, $x2, $y2) = $matches;
            for ($y = $y1; $y <= $y2; $y++) {
                for ($x = $x1; $x <= $x2; $x++) {
                    switch ($action) {
                        case 'turn off':
                            $grid[$y][$x] = 0;
                            break;
                        case 'turn on':
                            $grid[$y][$x] = 1;
                            break;
                        case 'toggle':
                            $grid[$y][$x] = $grid[$y][$x] ? 0 : 1;
                            break;
                    }
                }
            }
        }
        return array_sum(array_map(fn ($arr) => array_sum($arr), $grid));
    }

    protected function solvePart2(): string
    {
        $grid = array_fill(0, 1000, array_fill(0, 1000, 0));
        foreach ($this->getInputLines() as $instruction) {
            preg_match('/^([a-z ]+) ([0-9]+),([0-9]+) through ([0-9]+),([0-9]+)$/', $instruction, $matches);
            array_shift($matches);
            list($action, $x1, $y1, $x2, $y2) = $matches;
            for ($y = $y1; $y <= $y2; $y++) {
                for ($x = $x1; $x <= $x2; $x++) {
                    switch ($action) {
                        case 'turn off':
                            $grid[$y][$x] = max(0, $grid[$y][$x] - 1);
                            break;
                        case 'turn on':
                            $grid[$y][$x] += 1;
                            break;
                        case 'toggle':
                            $grid[$y][$x] += 2;
                            break;
                    }
                }
            }
        }
        return array_sum(array_map(fn ($arr) => array_sum($arr), $grid));
    }
}
