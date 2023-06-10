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
        Schema::create('apotek', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->boolean('rujukan');
            $table->string('rumah_sakit')->nullable();
            $table->json('obat');
            $table->json('harga_satuan');
            $table->integer('total_harga');
            $table->string('apoteker');
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
        Schema::dropIfExists('apotek');
    }
};
