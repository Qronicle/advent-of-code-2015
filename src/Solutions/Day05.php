<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day05
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day05 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        $count = 0;
        foreach ($this->getInputLines() as $line) {
            $count += $this->isNice($line) ? 1 : 0;
        }
        return $count;
    }

    protected function solvePart2(): string
    {
        $count = 0;
        foreach ($this->getInputLines() as $line) {
            $count += $this->isNicer($line) ? 1 : 0;
        }
        return $count;
    }

    protected function isNice(string $string): bool
    {
        if (preg_match('/ab|cd|pq|xy/', $string)) {
            return false;
        }
        if (preg_match_all('/a|e|i|o|u/', $string) < 3) {
            return false;
        }
        $len = strlen($string) - 1;
        for ($i = 0; $i < $len; $i++) {
            if ($string[$i] == $string[$i+1]) {
                return true;
            }
        }
        return false;
    }

    protected function isNicer(string $string): bool
    {
        $len = strlen($string);
        // It contains at least one letter which repeats with exactly one letter between them
        $bLen = $len - 2;
        $b = false;
        for ($i = 0; $i < $bLen; $i++) {
            if ($string[$i] == $string[$i+2]) {
                $b = true;
                break;
            }
        }
        if (!$b) {
            return false;
        }
        // It contains a pair of any two letters that appears at least twice in the string without overlapping
        $aLen = $len - 3;
        for ($i = 0; $i < $aLen; $i++) {
            for ($j = $i + 2; $j < $len - 1; $j++) {
                if ($string[$j] !== $string[$i]) {
                    continue;
                }
                if ($string[$j + 1] === $string[$i + 1]) {
                    return true;
                }
            }
        }
        return false;
    }
}
