<?php

namespace app\services\distance;

use GuzzleHttp\Client;

class Distance24 implements Distance
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $city1
     * @param string $city2
     * @return float
     * @throws DistanceException
     */
    public function getDistance(string $city1, string $city2): float
    {
        $response = $this->client->get("https://www.distance24.org/route.json?stops=$city1|$city2");

        if ($response->getStatusCode() !== 200) {
            throw new DistanceException('Сервис недоступен.', 230);
        }

        $body = json_decode($response->getBody()->getContents());

        if ($body->stops[0]->type === 'Invalid' || $body->stops[1]->type === 'Invalid') {
            throw new DistanceException('Переданы некорректные города.', 231);
        }

        return (float)$body->distances[0];
    }
}
