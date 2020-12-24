<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Keranjang extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_cart' => [
				'type' => 'INT',
				'constraint' => 11,
				'unsigned'	=> TRUE,
				'auto_increment' => TRUE
			],
			'id_produk' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'jumlah_pesan' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'harga_total' => [
				'type' => 'INT',
				'constraint' => 30
			]
		]);
		$this->forge->addKey('id_cart', TRUE);
		$this->forge->createTable('keranjang');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
