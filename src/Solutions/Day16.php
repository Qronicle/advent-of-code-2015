<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day16
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day16 extends AbstractSolution
{
    protected array $sues = [];

    protected array $scan = [
        'children'    => 3,
        'cats'        => 7,
        'samoyeds'    => 2,
        'pomeranians' => 3,
        'akitas'      => 0,
        'vizslas'     => 0,
        'goldfish'    => 5,
        'trees'       => 3,
        'cars'        => 2,
        'perfumes'    => 1,
    ];

    protected function init(): void
    {
        foreach ($this->getInputLines() as $inputLine) {
            $sueParts = explode(': ', $inputLine, 2);
            $compoundParts = explode(', ', $sueParts[1]);
            $sue = [];
            foreach ($compoundParts as $compoundPart) {
                list($compound, $value) = explode(': ', $compoundPart);
                $sue[$compound] = (int)$value;
            }
            $this->sues[] = $sue;
        }
    }

    protected function solvePart1(): string
    {
        foreach ($this->sues as $i => $sue) {
            foreach ($sue as $compound => $value) {
                if ($this->scan[$compound] !== $value) {
                    continue 2;
                }
            }
            return $i + 1;
        }
        return ':(';
    }

    protected function solvePart2(): string
    {
        foreach ($this->sues as $i => $sue) {
            foreach ($sue as $compound => $value) {
                switch ($compound) {
                    case 'cats':
                    case 'trees':
                        if ($this->scan[$compound] >= $value) {
                            continue 3;
                        }
                        break;
                    case 'pomeranians':
                    case 'goldfish':
                        if ($this->scan[$compound] <= $value) {
                            continue 3;
                        }
                        break;
                    default:
                        if ($this->scan[$compound] !== $value) {
                            continue 3;
                        }
                }
            }
            return $i + 1;
        }
        return ':(';
    }
}
