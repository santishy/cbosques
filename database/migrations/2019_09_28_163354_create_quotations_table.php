<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('qty');
            $table->string('description',300);
            $table->enum('iva',[false,true]);
            $table->bigInteger('cycle_id');
            $table->string('extension')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('department_item_id')->unsigned();
            $table->foreign('department_item_id')->references('id')->on('department_item')
                  ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')
                  ->onUpdate('cascade');
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
        Schema::dropIfExists('quotations');
    }
}
