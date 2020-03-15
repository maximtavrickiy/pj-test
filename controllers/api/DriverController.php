<?php

namespace app\controllers\api;

use app\models\Driver;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class DriverController extends ActiveController
{
    public $modelClass = 'app\models\Driver';

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

    public function actions()
    {
        return array_merge(
            parent::actions(),
            [
                'index' => [
                    'class' => 'yii\rest\IndexAction',
                    'modelClass' => $this->modelClass,
                    'checkAccess' => [$this, 'checkAccess'],
                    'prepareDataProvider' => function ($action) {
                        /* @var $model Driver */
                        $model = new $this->modelClass;
                        $query = $model::find();
                        $query->orderBy([
                            'first_name' => SORT_ASC,
                            'last_name' => SORT_ASC,
                        ]);

                        return new ActiveDataProvider(['query' => $query]);
                    }
                ]
            ]
        );
    }
}
