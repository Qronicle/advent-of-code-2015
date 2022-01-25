<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day15
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day15 extends AbstractSolution
{
    const MAX = 100;

    /** @var Ingredient[] */
    protected array $ingredients = [];

    protected function init(): void
    {
        foreach ($this->getInputLines() as $inputLine) {
            $nameSplit = explode(': ', $inputLine);
            $propSplit = explode(', ', $nameSplit[1]);
            $ingredient = new Ingredient();
            $ingredient->name = $nameSplit[0];
            foreach ($propSplit as $propStr) {
                list ($property, $value) = explode(' ', $propStr);
                $ingredient->$property = $value;
            }
            $this->ingredients[] = $ingredient;
        }
    }

    protected function solvePart1(): string
    {
        $permutations = $this->getPermutations(count($this->ingredients));
        $maxScore = -1;
        foreach ($permutations as $permutation) {
            foreach ($this->ingredients as $i => $ingredient) {
                $ingredient->amount = $permutation[$i];
            }
            $maxScore = max($maxScore, $this->calculateScore());
        }
        return $maxScore;
    }

    protected function solvePart2(): string
    {
        $permutations = $this->getPermutations(count($this->ingredients));
        $maxScore = -1;
        foreach ($permutations as $permutation) {
            foreach ($this->ingredients as $i => $ingredient) {
                $ingredient->amount = $permutation[$i];
            }
            if ($this->calculateCalories() != 500) {
                continue;
            }
            $maxScore = max($maxScore, $this->calculateScore());
        }
        return $maxScore;
    }

    protected function calculateScore(): int
    {
        $properties = ['capacity', 'durability', 'flavor', 'texture'];
        $total = 1;
        foreach ($properties as $property) {
            $sub = 0;
            foreach ($this->ingredients as $ingredient) {
                $sub += $ingredient->amount * $ingredient->$property;
            }
            $total *= max($sub, 0);
        }
        return $total;
    }

    protected function calculateCalories(): int
    {
        $calories = 0;
        foreach ($this->ingredients as $ingredient) {
            $calories += $ingredient->amount * $ingredient->calories;
        }
        return $calories;
    }

    protected function getPermutations(int $numLeft, int $total = self::MAX): array
    {
        if ($numLeft == 1) {
            return [[$total]];
        }
        $max = $total - $numLeft + 1;
        $possibilities = [];
        for ($i = 1; $i <= $max; $i++) {
            $nextPossibilities = $this->getPermutations($numLeft - 1, $total - $i);
            array_push($possibilities, ...array_map(function(array &$arr) use ($i) {
                array_unshift($arr, $i);
                return $arr;
            }, $nextPossibilities));
        }
        return $possibilities;
    }
}

class Ingredient
{
    public string $name;
    public int $capacity;
    public int $durability;
    public int $flavor;
    public int $texture;
    public int $calories;

    public int $amount = 0;
}