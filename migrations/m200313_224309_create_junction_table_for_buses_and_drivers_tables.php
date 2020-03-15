<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%buses_drivers}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%buses}}`
 * - `{{%drivers}}`
 */
class m200313_224309_create_junction_table_for_buses_and_drivers_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%buses_drivers}}', [
            'buses_id' => $this->integer(),
            'drivers_id' => $this->integer(),
            'PRIMARY KEY(buses_id, drivers_id)',
        ]);

        // creates index for column `buses_id`
        $this->createIndex(
            '{{%idx-buses_drivers-buses_id}}',
            '{{%buses_drivers}}',
            'buses_id'
        );

        // add foreign key for table `{{%buses}}`
        $this->addForeignKey(
            '{{%fk-buses_drivers-buses_id}}',
            '{{%buses_drivers}}',
            'buses_id',
            '{{%buses}}',
            'id',
            'CASCADE'
        );

        // creates index for column `drivers_id`
        $this->createIndex(
            '{{%idx-buses_drivers-drivers_id}}',
            '{{%buses_drivers}}',
            'drivers_id'
        );

        // add foreign key for table `{{%drivers}}`
        $this->addForeignKey(
            '{{%fk-buses_drivers-drivers_id}}',
            '{{%buses_drivers}}',
            'drivers_id',
            '{{%drivers}}',
            'id',
            'CASCADE'
        );

        $buses = \app\models\Bus::find()->all();
        $busesCount = count($buses);

        /** @var \app\models\Driver $driver */
        foreach (\app\models\Driver::find()->all() as $driver) {
            $offset = rand(0, $busesCount);
            $limit = rand(0, 3);
            $driverBuses = array_slice($buses, $offset, $limit);

            foreach ($driverBuses as $driverBus) {
                $driver->link('buses', $driverBus);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%buses}}`
        $this->dropForeignKey(
            '{{%fk-buses_drivers-buses_id}}',
            '{{%buses_drivers}}'
        );

        // drops index for column `buses_id`
        $this->dropIndex(
            '{{%idx-buses_drivers-buses_id}}',
            '{{%buses_drivers}}'
        );

        // drops foreign key for table `{{%drivers}}`
        $this->dropForeignKey(
            '{{%fk-buses_drivers-drivers_id}}',
            '{{%buses_drivers}}'
        );

        // drops index for column `drivers_id`
        $this->dropIndex(
            '{{%idx-buses_drivers-drivers_id}}',
            '{{%buses_drivers}}'
        );

        $this->dropTable('{{%buses_drivers}}');
    }
}
