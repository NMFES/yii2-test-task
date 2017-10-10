<?php

use yii\db\Migration;

/**
 * Handles the creation of table `categories`.
 */
class m171009_202420_create_categories_table extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $this->createTable('categories', [
            'id' => $this->primaryKey(),
            'title' => $this->string(30)->notNull(),
            'link' => $this->string()->notNull(),
            'path' => $this->string()->notNull(),
            'is_last' => $this->integer()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('categories');
    }

}
