<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%buses}}`.
 */
class m200313_221348_create_buses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $busesNames = include 'data/buses.php';
        $faker = Faker\Factory::create();

        $this->createTable('{{%buses}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'average_speed' => $this->float()->notNull(),
        ]);

        foreach ($busesNames as $busName) {
            $this->insert('buses', [
                'name' => $busName,
                'average_speed' => $faker->randomFloat(1, 40, 100),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%buses}}');
    }
}
