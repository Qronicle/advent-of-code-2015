<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;
use Exception;

/**
 * Class Day07
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day07 extends AbstractSolution
{
    protected array $vars = [];

    protected function solvePart1(): string
    {
        $this->run($this->getInputLines());
        return $this->getValue('a');
    }

    protected function solvePart2(): string
    {
        $a = $this->solvePart1();
        $instructions = $this->getInputLines();
        $instructions[3] = $a . ' -> b';
        $this->run($instructions);
        return $this->getValue('a');
    }

    protected function run(array $instructions): void
    {
        $this->vars = [];
        while ($instructions) {
            foreach ($instructions as $i => $instruction) {
                try {
                    $this->parse($instruction);
                    unset($instructions[$i]);
                } catch (UnknownVariableException $ex) {
                    // continue
                }
            }
        }
    }

    protected function parse(string $instruction): void
    {
        list($calculation, $target) = explode(' -> ', $instruction);
        $calculation = explode(' ', $calculation);
        switch (count($calculation)) {
            case 1:
                $value = $this->getValue($calculation[0]);
                break;
            case 2:
                $a = $this->getValue($calculation[1]);
                switch ($calculation[0]) {
                    case 'NOT':
                        $bin = str_pad(decbin($a), 16, '0', STR_PAD_LEFT);
                        $result = '';
                        for ($i = 0; $i < 16; $i++) {
                            $result .= $bin[$i] ? 0 : 1;
                        }
                        $value = bindec($result);
                        break;
                    default:
                        throw new Exception('Unexpected instruction with 2 params');
                }
                break;
            case 3:
                $a = $this->getValue($calculation[0]);
                $b = $this->getValue($calculation[2]);
                switch ($calculation[1]) {
                    case 'AND':
                        $value = $a & $b;
                        break;
                    case 'OR':
                        $value = $a | $b;
                        break;
                    case 'LSHIFT':
                        $value = $a << $b;
                        break;
                    case 'RSHIFT':
                        $value = $a >> $b;
                        break;
                    default:
                        throw new Exception('Unexpected instruction with 3 params');
                }
                break;
            default:
                throw new Exception('Unexpected instruction param count');
        }
        $this->vars[$target] = $value;
    }
    
    protected function getValue(string $identifier): int
    {
        if (is_numeric($identifier)) {
            return $identifier;
        }
        if (!isset($this->vars[$identifier])) {
            throw new UnknownVariableException();
        }
        return $this->vars[$identifier] ?? 0;
    }
}

class UnknownVariableException extends Exception
{

}