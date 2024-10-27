<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'auto_increment'=>true,
                'unsigned'=>true
            ],
            'name'=>[
                'type'=>'VARCHAR',
                'constraint'=>20,
                'null'=>false,
            ],
            'email'=>[
                'type'=>'VARCHAR',
                'constraint'=>20,
                'null'=>false,
            ],
            'phone_no'=>[
                'type'=>'VARCHAR',
                'constraint'=>20,
                'null'=>true,
            ],
            'created_at datetime default current_timestamp'

        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
