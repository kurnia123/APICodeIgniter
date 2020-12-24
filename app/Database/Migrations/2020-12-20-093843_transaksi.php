<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_transaksi' => [
				'type' => 'INT',
				'constraint' => 10,
				'unsigned'	=> TRUE,
				'auto_increment' => TRUE
			],
			'id_user'		=> [
				'type' => 'INT',
				'constraint' => 10
			],
			'id_produk' => [
				'type' => 'INT',
				'constraint' => 10
			],
			'id_pembayaran' => [
				'type' => 'INT',
				'constraint' => 10
			],
			'tanggal_transaksi' => [
				'type' => 'DATETIME',
				'null' => TRUE
			]
		]);
		$this->forge->addKey('id_transaksi', TRUE);
		$this->forge->createTable('transaksi');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
