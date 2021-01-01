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
			'firstname_user' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'lastname_user' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'username_user' => [
				'type' => 'VARCHAR',
				'constraint' => '100'
			],
			'password_user' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'alamat' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'provinsi' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'kabupaten' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'kecamatan' => [
				'type' => 'VARCHAR',
				'constraint' => '255'
			],
			'no_telephone' => [
				'type' => 'INT',
				'constraint' => '11'
			],
			'bio' => [
				'type' => 'VARCHAR',
				'constraint' => '11',
				'null' => true
			],
			'is_seller' => [
				'type' => 'tinyint',
				'constraint' => '1',
				'null' => true
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
