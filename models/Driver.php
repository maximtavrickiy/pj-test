<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "drivers".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 *DESC
 * @property Buses[] $buses
 */
class Driver extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'drivers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'date_of_birth'], 'required'],
            [['date_of_birth'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'date_of_birth' => 'Date Of Birth',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'first_name',
            'last_name',
            'date_of_birth',
            'age' => function () {
                return date_diff(date_create($this->date_of_birth), date_create('today'))->y;
            },
        ];
    }

    /**
     * Gets query for [[Buses]].
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getBuses()
    {
        return $this->hasMany(Bus::class, ['id' => 'buses_id'])->viaTable('buses_drivers', ['drivers_id' => 'id']);
    }
}
