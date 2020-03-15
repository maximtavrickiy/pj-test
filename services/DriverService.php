<?php

namespace app\services;

use app\models\Bus;
use app\models\Driver;
use Yii;

class DriverService
{
    const MAX_HOURS_FOR_DAY = 8;

    public function getDriverDaysForDistance(float $distanceInKm, int $page = 1, int $limit = 20, ?Driver $driver = null)
    {
        $offset = ($page - 1) * $limit;

        if ($driver) {
            $where = "WHERE drivers.id = {$driver->id}";
        }

        return Yii::$app->getDb()->createCommand("
            SELECT drivers.*,
            {$distanceInKm} / c.max_average_speed / " . self::MAX_HOURS_FOR_DAY . " days, 
            CEIL({$distanceInKm} / c.max_average_speed / " . self::MAX_HOURS_FOR_DAY . ") days_for_human
            FROM drivers
                     INNER JOIN `buses_drivers` ON `drivers`.`id` = `buses_drivers`.`drivers_id`
                     INNER JOIN `buses` ON `buses_drivers`.`buses_id` = `buses`.`id`
                     INNER JOIN (
                SELECT MAX(average_speed) max_average_speed, `buses_drivers`.drivers_id as driver_id
                FROM `buses`
                         INNER JOIN `buses_drivers` on `buses`.id = `buses_drivers`.buses_id
                GROUP BY `buses_drivers`.drivers_id
            ) c on drivers.id = c.driver_id and buses.average_speed = c.max_average_speed
            " . (isset($where) ? $where : '') . "
            ORDER BY days
            LIMIT {$limit} OFFSET {$offset};
        ")->queryAll();
    }
}
