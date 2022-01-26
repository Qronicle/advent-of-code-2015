<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day17
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day17 extends AbstractSolution
{
    protected function solvePart1(): string
    {
        return count($this->getSolutions());
    }

    protected function solvePart2(): string
    {
        $solutions = $this->getSolutions();
        $min = min($solutions);
        $minSolutions = array_filter($solutions, fn ($val) => $val == $min);
        return count($minSolutions);
    }

    protected function getSolutions(): array
    {
        $target = 150;
        $containers = $this->getInputLines();
        rsort($containers);
        $options = ['' => ['used' => [], 'sum' => 0, 'available' => $containers]];
        $solutions = [];
        while ($options) {
            $newOptions = [];
            foreach ($options as $option) {
                foreach ($option['available'] as $c => $container) {
                    if ($option['sum'] + $container > $target) {
                        unset($option['available'][$c]);
                        continue;
                    }
                    $newOption = $option;
                    $newOption['used'][] = $c;
                    rsort($newOption['used']);
                    $newOption['sum'] += $container;
                    unset($newOption['available'][$c]);
                    if ($newOption['sum'] == $target) {
                        $key = implode(',', $newOption['used']);
                        $solutions[$key] = count($newOption['used']);
                        continue;
                    }
                    if ($newOption['available']) {
                        $newOptions[implode(',', $newOption['used'])] = $newOption;
                    }
                }
            }
            $options = $newOptions;
        }
        return $solutions;
    }
}
