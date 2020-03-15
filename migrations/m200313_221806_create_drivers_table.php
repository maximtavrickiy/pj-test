<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%drivers}}`.
 */
class m200313_221806_create_drivers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = Faker\Factory::create();

        $this->createTable('{{%drivers}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'date_of_birth' => $this->date()->notNull(),
        ]);

        for ($i = 0; $i < 1000; $i++) {
            $this->insert('drivers', [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'date_of_birth' => $faker->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%drivers}}');
    }
}
