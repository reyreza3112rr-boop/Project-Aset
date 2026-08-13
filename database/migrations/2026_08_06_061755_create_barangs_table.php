<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('barangs', function (Blueprint $table) {
        $table->id('id_barang'); // Menggunakan id_barang sebagai Primary Key
        $table->unsignedBigInteger('id_kategori')->nullable();
        $table->unsignedBigInteger('id_ruangan')->nullable();
        $table->string('nama_barang');
        $table->string('merek')->nullable();
        $table->bigInteger('harga')->default(0);
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
        Schema::dropIfExists('barangs');
    }
}
