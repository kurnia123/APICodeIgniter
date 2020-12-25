<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Promo extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_promo' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned'	=> TRUE,
				'auto_increment' => TRUE
			],
			'id_user'		=> [
				'type' => 'INT',
				'constraint' => '11'
			],
			'id_produk' => [
				'type' => 'INT',
				'constraint' => 10,
				'null' => true
			],
			'jumlah_promo_percent' => [
				'type' => 'INT',
				'constraint' => 10
			],
			'jumlah_promo_max' => [
				'type' => 'INT',
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
