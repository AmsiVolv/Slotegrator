<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('things', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prize_type_id');

            $table->string('name');
            $table->integer('count');
            $table->boolean('status')->default(1);

            $table->foreign('prize_type_id')
                ->references('id')
                ->on('prize_types')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');

            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('things');
    }
}
