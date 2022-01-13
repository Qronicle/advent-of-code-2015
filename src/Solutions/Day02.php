<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day02
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day02 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        $totalWrapSize = 0;
        foreach ($this->getInputLines() as $line) {
            $totalWrapSize += $this->getWrapSize(explode('x', $line));
        }
        return $totalWrapSize;
    }

    protected function solvePart2(): string
    {
        $totalRibbonLength = 0;
        foreach ($this->getInputLines() as $line) {
            $totalRibbonLength += $this->getRibbonLength(explode('x', $line));
        }
        return $totalRibbonLength;
    }

    protected function getRibbonLength(array $dimensions): int
    {
        sort($dimensions);
        return ($dimensions[0] * 2) + ($dimensions[1] * 2) + (array_product($dimensions));
    }
}
