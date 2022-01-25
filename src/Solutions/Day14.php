<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day14
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day14 extends AbstractSolution
{
    const RACE_DURATION = 2503;

    protected array $reindeer = [];

    protected function init(): void
    {
        foreach ($this->getInputLines() as $inputLine) {
            $parts = explode(' ', $inputLine);
            $this->reindeer[] = new Reindeer($parts[0], $parts[3], $parts[6], $parts[13]);
        }
    }

    protected function solvePart1(): string
    {
        return max(array_map(fn(Reindeer $reindeer) => $reindeer->distanceAt(self::RACE_DURATION), $this->reindeer));
    }

    protected function solvePart2(): string
    {
        $numReindeer = count($this->reindeer);
        for ($i = 0; $i < self::RACE_DURATION; $i++) {
            foreach ($this->reindeer as $reindeer) {
                $reindeer->tick();
            }
            usort($this->reindeer, fn(Reindeer $a, Reindeer $b) => $a->currDistance < $b->currDistance);
            $topDist = $this->reindeer[0]->currDistance;
            $this->reindeer[0]->points++;
            for ($j = 1; $j < $numReindeer; $j++) {
                if ($topDist > $this->reindeer[$j]->currDistance) {
                    break;
                }
                $this->reindeer[$j]->points++;
            }
        }
        usort($this->reindeer, fn(Reindeer $a, Reindeer $b) => $a->points < $b->points);
        return $this->reindeer[0]->points;
    }
}

class Reindeer
{
    public string $name;
    public int $speed;
    public int $flyDuration;
    public int $restDuration;
    public int $stintDuration;

    public int $currDistance = 0;
    public int $currTime = 0;
    public int $points = 0;

    public function __construct(string $name, int $speed, int $flyDuration, int $restDuration)
    {
        $this->name = $name;
        $this->speed = $speed;
        $this->flyDuration = $flyDuration;
        $this->restDuration = $restDuration;
        $this->stintDuration = $flyDuration + $restDuration;
    }

    public function distanceAt(int $time): int
    {
        $fullStints = floor($time / $this->stintDuration);
        $totalDistance = $fullStints * $this->speed * $this->flyDuration;
        $extraFlyTime = min($this->flyDuration, $time % $this->stintDuration);
        $totalDistance += $this->speed * $extraFlyTime;
        return $totalDistance;
    }

    public function tick(): self
    {
        $step = $this->currTime++ % $this->stintDuration;
        $this->currDistance += $step < $this->flyDuration ? $this->speed : 0;
        return $this;
    }
}