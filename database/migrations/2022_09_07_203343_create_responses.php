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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->integer('Night');
            $table->integer('Morning');
            $table->integer('Day');
            $table->integer('Evening');
            $table->text('Location');
            $table->unsignedBigInteger('id_inquries');
            $table->foreign('id_inquries')->references('id')->on('inquiries')->onDelete('cascade')->onUpdate('cascade');
           

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
        Schema::dropIfExists('responses');
    }
};
