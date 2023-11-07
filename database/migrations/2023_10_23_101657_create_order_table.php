<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id_order');
            $table->integer('id_user');
            $table->integer('id_produk');
            $table->integer('quantity');
            $table->integer('harga');
            $table->string('name');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->text('alamat');
            $table->integer('kode_pos');
            $table->string('no_hp');
            $table->string('gambar');
            $table->enum('status', ['konfirmasi', 'belum'])->default('belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
