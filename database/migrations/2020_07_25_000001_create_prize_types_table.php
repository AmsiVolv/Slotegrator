<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prize_types', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['points', 'money', 'thing'])->unique();
            $table->integer('count')->nullable();
            $table->boolean('active')->default(1);

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
        Schema::dropIfExists('prize_types');
    }
}
