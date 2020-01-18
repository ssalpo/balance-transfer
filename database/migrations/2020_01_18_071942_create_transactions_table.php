<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('sender_id')->nullable();
            $table->string('sender_name')->nullable();

            $table->unsignedInteger('receiver_id')->nullable();
            $table->string('receiver_name')->nullable();

            $table->double('amount');
            $table->timestamps();

            $table->foreign('sender_id')
                ->references('id')->on('users')
                ->onDelete('set null');

            $table->foreign('receiver_id')
                ->references('id')->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
