<?php

namespace app\services\distance;

interface Distance
{
    public function getDistance(string $city1, string $city2): float;
}
