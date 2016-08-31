<?php

use yii\db\Migration;

class m160831_002240_alter_reservation_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%reservation}}', 'creditcard_id', $this->string(40));
    }

    public function down()
    {
        $this->dropColumn('{{%reservation}}', 'creditcard_id');
    }
}
