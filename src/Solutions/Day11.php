<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day11
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day11 extends AbstractSolution
{
    protected array $characters;
    protected array $resets;
    protected array $incMap;

    protected function init(): void
    {
        $this->characters = str_split('abcdefghijklmnopqrstuvwxyz');
        $this->resets = array_combine(str_split('ilo'), str_split('ilo'));
        $this->incMap = array_combine($this->characters, str_split('bcdefghijklmnopqrstuvwxyza'));
    }

    protected function solvePart1(): string
    {
        $password = $this->rawInput;
        do {
            $password = $this->inc($password);
        } while (!$this->isValid($password));
        return $password;
    }

    protected function solvePart2(): string
    {
        $this->rawInput = $this->solvePart1();
        return $this->solvePart1();
    }

    protected function inc(string $password): string
    {
        for ($i = 7; $i >= 0; $i--) {
            $next = $this->incMap[$password[$i]];
            $password[$i] = $next;
            if (isset($this->resets[$next])) {
                $password[$i] = $this->incMap[$next];
                for ($j = $i + 1; $j < 8; $j++) {
                    $password[$j] = 'a';
                }
            }
            if ($next != 'a') break;
        }
        return $password;
    }

    protected function isValid(string $password): bool
    {
        $straight = false;
        $doubles = [];
        for ($i = 0; $i < 7; $i++) {
            if (!$straight && $i <= 5 && $password[$i] != 'y' && $password[$i] != 'z'
                && $this->incMap[$password[$i]] == $password[$i + 1]
                && $this->incMap[$password[$i + 1]] == $password[$i + 2]
                ) {
                $straight = true;
                if (count($doubles) >= 2) {
                    return true;
                }
            }
            if (!isset($doubles[$password[$i]]) && $password[$i] == $password[$i + 1]) {
                $doubles[$password[$i]] = true;
                if (count($doubles) == 2 && $straight) {
                    return true;
                }
            }
        }
        return false;
    }
}
