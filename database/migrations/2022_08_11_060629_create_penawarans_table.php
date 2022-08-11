<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penawarans', function (Blueprint $table) {
            $table->id();
            // relation with barangs table
            $table->bigInteger('kode_barang')->unsigned();
            $table->foreign('kode_barang')->references('id')->on('barangs')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('harga_penawaran');
            $table->bigInteger('stok_barang');
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
        Schema::dropIfExists('penawarans');
    }
};
