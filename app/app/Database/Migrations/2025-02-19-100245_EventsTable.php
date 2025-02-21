<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EventsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'                 => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'description'          => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'organizer_first_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'organizer_last_name'  => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'organizer_phone'      => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'organizer_email'      => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug'                 => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'shorturl'             => [
                'type'       => 'VARCHAR',
                'constraint' => '7',
                'unique'     => true,
            ],
            'qrcode'               => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'social_links'         => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at'           => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'           => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('events');
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
