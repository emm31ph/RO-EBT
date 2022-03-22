<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Signatories', function (Blueprint $table) {
            $table->id();
            $table->string('type',5)->nullable();
            $table->string('signatory1',100)->nullable(); 
            $table->string('signatory2',100)->nullable(); 
            $table->string('signatory3',100)->nullable();  
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
        Schema::dropIfExists('Signatories');
    }
}
