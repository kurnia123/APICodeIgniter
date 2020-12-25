<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_kategori' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned'	=> TRUE,
				'auto_increment' => TRUE
			],
			'nama_kategori' => [
				'type' => 'VARCHAR',
				'constraint' => 10
			],
			'promo_expired' => [
				'type' => 'DATETIME',
				'null' => TRUE
			]
		]);
		$this->forge->addKey('id_promo', TRUE);
		$this->forge->createTable('promo');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
