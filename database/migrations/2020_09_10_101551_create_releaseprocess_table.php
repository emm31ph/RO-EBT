<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseprocessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releaseprocess', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->date('deliver_date')->nullable();
            $table->string('area',100)->nullable();
            $table->string('plate',100)->nullable();
            $table->string('truckno',100)->nullable();
            $table->string('driver',100)->nullable();
            $table->string('ro_no',100)->comment('release order number');
            $table->string('status',2)->default('00');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('release_items', function (Blueprint $table) {
            $table->foreignId('releaseprocess_id',11);
            $table->foreignId('releasetfi_id',11);
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
        Schema::dropIfExists('releaseprocess');
        Schema::dropIfExists('release_items');
    }
}
