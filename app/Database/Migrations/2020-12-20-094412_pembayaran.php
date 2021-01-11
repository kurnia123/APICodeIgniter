<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembayaran extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_pembayaran' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned'	=> TRUE,
				'auto_increment' => TRUE
			],
			'jumlah_bayar' => [
				'type' => 'INT',
				'constraint' => 20
			],
			'id_produk' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'id_user' => [
				'type' => 'INT',
				'constraint' => 11
			],
			'tanggal_pembayaran' => [
				'type' => 'DATETIME',
				'null' => TRUE
			]
		]);
		$this->forge->addKey('id_pembayaran', TRUE);
		$this->forge->createTable('pembayaran');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
