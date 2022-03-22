<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_item', function (Blueprint $table) {
            $table->id();
             $table->string('header1')->nullable();   
             $table->string('header2')->nullable();   
             $table->string('header3')->nullable();   
             $table->string('itemcode')->nullable();   
             $table->string('type',5)->nullable();   
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
        Schema::dropIfExists('report_item');
    }
}
