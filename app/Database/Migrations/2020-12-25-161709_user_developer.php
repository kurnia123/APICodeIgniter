<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserDeveloper extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_user_dev' => [
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
			]
		]);

		$this->forge->addKey('id_user_dev', TRUE);
		$this->forge->createTable('user_developer');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
