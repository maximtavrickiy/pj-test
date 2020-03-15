<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "buses".
 *
 * @property int $id
 * @property string $name
 * @property float $average_speed
 *
 * @property Drivers[] $drivers
 */
class Bus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'buses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'average_speed'], 'required'],
            [['average_speed'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'average_speed' => 'Average Speed',
        ];
    }

    /**
     * Gets query for [[Drivers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasMany(Driver::class, ['id' => 'driver_id'])->viaTable('buses_drivers', ['bus_id' => 'id']);
    }
}
