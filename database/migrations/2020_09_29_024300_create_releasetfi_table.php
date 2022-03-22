<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleasetfiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releasetfi', function (Blueprint $table) {
            $table->string('docno',40)->comment('Document Number');
            $table->string('Customer',100)->comment('BP Name');
            $table->string('Address',300)->nullable();
            $table->string('Sales',100)->comment('SALES PERSON NAME');
            $table->string('SO_no',100)->comment('SO No.')->nullable();
            $table->string('PO_no',100)->comment('BP Ref. No.')->nullable();
            $table->date('Date')->comment('Posting Date')->nullable();
            $table->string('Attention',100)->comment('Name')->nullable();;
            $table->decimal('Qty',25,6)->comment('Quantity');
            $table->string('Description',100)->comment('Item Description')->nullable();
            $table->string('Stock_Condition',100)->comment('Description')->default('');
            $table->DECIMAL('Unit_price',25,6)->comment('Unit Price')->default('0.000000');
            $table->decimal('Amount',25,6)->nullable();
            $table->decimal('VAT_Amount',25,6)->comment('Vat')->default('0.000000');
            $table->decimal('Discounted_Amount',25,6)->comment('Line Total Disc')->default('0.000000');
            $table->string('Terms',100)->comment('Payment Term Name')->default('');
            $table->string('Unit',100)->comment('Unit of Measure')->default('');
            $table->string('fieldvaluedesc',100)->comment('Description')->default('');
            $table->decimal('Line_Discount',25,6)->comment('Discount (%)')->default('0.000000');
            $table->decimal('Percentage_Disc',25,6)->comment('Discount (%)')->default('0.000000');
            $table->decimal('discamount',25,6)->comment('Discount')->default('0.000000');
            $table->string('u_qty_service',100)->comment('Service Qty')->default('');
            
            $table->string('itemcode',30)->nullable();
            $table->string('MAKENAME',15)->nullable();
            $table->string('U_STOCKCODE',100)->nullable();
            $table->string('status',2)->default('00');
            $table->integer('importby');
            
            $table->id();
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
        Schema::dropIfExists('releasetfi');
    }
}
