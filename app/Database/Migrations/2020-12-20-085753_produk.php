<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
	public function up()
	{
		$this->db->disableForeignKeyChecks();
		$this->forge->addField([
			'id_produk'       => [
				'type'		=> 'INT',
				'constraint' => 11,
				'unsigned'	=> TRUE,
				'auto_increment' => TRUE
			],
			'nama_produk' => [
				'type'		=> 'VARCHAR',
				'constraint' => '255'
			],
			'id_user' => [
				'type'		=> 'INT',
				'constraint' => '10'
			],
			'filename_produk' => [
				'type'		=> 'VARCHAR',
				'constraint' => '255'
			],
			'deskripsi_produk' => [
				'type'		=> 'VARCHAR',
				'constraint' => '500'
			],
			'stok_produk' => [
				'type'		=> 'INT',
				'constraint' => 11,
				'null' => false
			],
			'kategori_produk' => [
				'type'		=> 'VARCHAR',
				'constraint' => '100'
			],
			'harga_produk' => [
				'type'		=> 'INT',
				'constraint' => 20
			]
		]);
		$this->forge->addKey('id_produk', TRUE);
		$this->forge->createTable('produk');
		$this->db->enableForeignKeyChecks();
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
