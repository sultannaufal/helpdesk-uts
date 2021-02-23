<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('theme', 255);
            $table->text('content');
            $table->string('attachment', 255)->nullable();
            $table->string('status', 20)->default('new');

            $table->unsignedBigInteger('client_id')
                ->references('id')
                ->on('user')
                ->onDelete('CASCADE');

            $table->unsignedBigInteger('manager_id')
                ->references('id')
                ->on('user')
                ->nullable()
                ->onDelete('CASCADE');

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
        Schema::dropIfExists('tickets');
    }
}
