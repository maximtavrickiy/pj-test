<?php

namespace app\controllers\api;

use app\models\Driver;
use app\services\distance\Distance;
use app\services\DriverService;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class DistanceController extends Controller
{
    /**
     * @var DriverService
     */
    private $service;
    /**
     * @var Distance
     */
    private $distance;

    public function __construct($id, $module, $config = [], DriverService $service, Distance $distance)
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->distance = $distance;
    }

    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $request = Yii::$app->request;
        $from = (string)$request->get('from');
        $to = (string)$request->get('to');
        $page = (int)$request->get('page', 1) || 1;
        $limit = 20;

        if (!$from || !$to) {
            throw new BadRequestHttpException('Params "from" and "to" are required!', 401);
        }

        try {
            $distance = $this->distance->getDistance($from, $to);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }

        return $this->service->getDriverDaysForDistance($distance, $page, $limit);
    }

    public function actionView($driver_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        /** @var Driver $driver */
        $driver = Driver::findOne($driver_id);
        $request = Yii::$app->request;
        $from = (string)$request->get('from');
        $to = (string)$request->get('to');

        if (!$from || !$to) {
            throw new BadRequestHttpException('Params "from" and "to" are required!', 401);
        }

        try {
            $distance = $this->distance->getDistance($from, $to);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }

        return $this->service->getDriverDaysForDistance($distance, 1, 1, $driver)[0];
    }
}
