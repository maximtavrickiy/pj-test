<?php

namespace app\controllers\api;

use yii\rest\ActiveController;

class BusController extends ActiveController
{
    public $modelClass = 'app\models\Bus';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::class,
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
}
