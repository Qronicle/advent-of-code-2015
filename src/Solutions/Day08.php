<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day08
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day08 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        $codeLen = 0;
        $strLen = 0;
        foreach ($this->getInputLines() as $line) {
            $codeLen += strlen($line);
            $strLen += $this->getStringLength($line);
        }
        return $codeLen - $strLen;
    }

    protected function solvePart2(): string
    {
        $codeLen = 0;
        $encCodeLen = 0;
        foreach ($this->getInputLines() as $line) {
            $codeLen += strlen($line);
            $encCodeLen += strlen(addslashes($line)) + 2;
        }
        return $encCodeLen - $codeLen;
    }

    protected function getStringLength(string $code): int
    {
        $len = 0;
        $end = strlen($code) - 1;
        for ($i = 1; $i < $end; $i++) {
            $len++;
            if ($code[$i] == '\\') {
                $i++;
                if ($code[$i] == 'x') {
                   $i+= 2;
                }
            }
        }
        return $len;
    }
}