<?php

namespace app\services\distance;

class DummyDistance implements Distance
{
    public function getDistance(string $city1, string $city2): float
    {
        return (float)rand(30, 10000);
    }
}
