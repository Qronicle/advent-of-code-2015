<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day13
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day13 extends AbstractSolution
{
    protected array $people;

    protected function init(): void
    {
        foreach ($this->getInputLines() as $line) {
            $parts = explode(' ', $line);
            $source = $parts[0];
            $points = $parts[3] * ($parts[2] == 'gain' ? 1 : -1);
            $target = substr($parts[10], 0, -1);
            $this->people[$source][$target] = $points;
        }
    }

    protected function solvePart1(): string
    {
        return $this->getBestArrangementScore();
    }

    protected function solvePart2(): string
    {
        foreach ($this->people as $name => $others) {
            $this->people[$name]['Me'] = 0;
        }
        $this->people['Me'] = array_combine(array_keys($this->people), array_fill(0, count($this->people), 0));
        return $this->getBestArrangementScore();
    }

    protected function getBestArrangementScore(): int
    {
        $starter = key($this->people);
        $newArrangements = [[$starter => $starter]];
        do {
            $arrangements = $newArrangements;
            $newArrangements = [];
            foreach ($arrangements as $arrangement) {
                $current = end($arrangement);
                $next = null;
                foreach ($this->people[$current] as $next => $points) {
                    if (!isset($arrangement[$next])) {
                        $newArrangement = $arrangement;
                        $newArrangement[$next] = $next;
                        $newArrangements[] = $newArrangement;
                    }
                }
            }
        } while ($newArrangements);
        $best = PHP_INT_MIN;
        foreach ($arrangements as $arrangement) {
            $arrangement = array_values($arrangement);
            $score = 0;
            foreach ($arrangement as $i => $current) {
                $prev = $arrangement[$i - 1] ?? end($arrangement);
                $next = $arrangement[$i + 1] ?? $arrangement[0];
                $score += $this->people[$current][$prev] + $this->people[$current][$next];
            }
            $best = max($score, $best);
        }
        return $best;
    }
}
