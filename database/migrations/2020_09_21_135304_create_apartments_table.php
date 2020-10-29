<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            // user_id
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
            ->references('id')
            ->on('users');

            $table->string('title');
            $table->integer('rooms')->nullable();
            $table->integer('baths')->nullable();
            $table->integer('beds')->nullable();
            $table->integer('mqs')->nullable();
            $table->longText('description')->nullable();
            $table->integer('guests')->nullable();
            $table->double('latitude', 12, 6);
            $table->double('longitude', 12, 6);
            $table->string('address');
            $table->string('city');
            $table->integer('zip')->nullable();
            $table->longText('image')->nullable();
            $table->boolean('active');
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
        Schema::dropIfExists('apartments');
    }
}
