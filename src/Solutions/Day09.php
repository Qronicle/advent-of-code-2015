<?php

namespace AdventOfCode\Solutions;

use AdventOfCode\Common\Solution\AbstractSolution;

/**
 * Class Day09
 *
 * @package AdventOfCode\Solutions
 * @author  Ruud Seberechts
 */
class Day09 extends AbstractSolution
{
    protected array $distances = [];

    protected function solvePart1(): string
    {
        $minDist = PHP_INT_MAX;
        foreach ($this->getRoutes() as $route) {
            $minDist = min($minDist, $route->distance);
        }
        return $minDist;
    }

    protected function solvePart2(): string
    {
        $maxDist = 0;
        foreach ($this->getRoutes() as $route) {
            $maxDist = max($maxDist, $route->distance);
        }
        return $maxDist;
    }

    protected function getRoutes(): array
    {
        $this->parseInput();
        $routes = array_map(
            fn($v) => (object)['cities' => [$v => $v], 'distance' => 0],
            array_keys($this->distances)
        );
        for ($i = 0; $i < count($this->distances) - 1; $i++) {
            $newRoutes = [];
            foreach ($routes as $route) {
                $destinations = $this->distances[end($route->cities)];
                foreach ($destinations as $city => $distance) {
                    if (isset($route->cities[$city])) {
                        continue;
                    }
                    $newRoute = clone $route;
                    $newRoute->cities[$city] = $city;
                    $newRoute->distance += $distance;
                    $newRoutes[] = $newRoute;
                }
            }
            $routes = $newRoutes;
        }
        return $routes;
    }

    protected function parseInput(): void
    {
        foreach ($this->getInputLines() as $line) {
            list($cities, $distance) = explode(' = ', $line);
            $cities = explode(' to ', $cities);
            $this->distances[$cities[0]][$cities[1]] = $distance;
            $this->distances[$cities[1]][$cities[0]] = $distance;
        }
        foreach ($this->distances as $city => &$destinations) {
            asort($destinations);
        }
    }
}
