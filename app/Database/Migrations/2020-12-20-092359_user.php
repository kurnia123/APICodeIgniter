<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_user' => [
				'type' => 'INT',
				'constraint' => '11',
				'auto_increment' => TRUE
			],
			'name_user' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'username_user' => [
				'type' => 'VARCHAR',
				'constraint' => '30'
			],
			'password_user' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'is_seller' => [
				'type' => 'tinyint',
				'constraint' => '1'
			]
		]);

		$this->forge->addKey('id_user', TRUE);
		$this->forge->createTable('user');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('user');
	}
}
