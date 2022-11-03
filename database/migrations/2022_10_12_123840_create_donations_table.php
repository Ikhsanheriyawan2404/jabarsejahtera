<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->decimal('total_budget', 15, 2);
            $table->string('image');
            $table->string('location');
            $table->enum('category', ['Bencana Alam', 'Yatim Piatu', 'Disabilitas', 'Kaum Dhuafa', 'Kegiatan Sosial', 'Lingkungan', 'Infrastruktur', 'Bantuan Medis']);
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
        Schema::dropIfExists('donations');
    }
}
