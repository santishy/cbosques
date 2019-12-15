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
            $table->double('qty');
            $table->string('description',300);
            $table->boolean('iva');
            $table->double('total')->default(0);
            $table->bigInteger('cycle_id');
            //$table->string('archive')->nullable();
            $table->string('status',25);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
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
