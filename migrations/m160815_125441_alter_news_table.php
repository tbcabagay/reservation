<?php

use yii\db\Migration;

class m160815_125441_alter_news_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%news}}', 'photo', $this->string(255));
    }

    public function down()
    {
        $this->dropColumn('{{%news}}', 'photo');
    }
}
