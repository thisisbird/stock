<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_info', function (Blueprint $table) {
            $table->id();
            $table->string('company_code', 20)->comment('券商代碼');
            $table->string('company_name', 20)->comment('券商名稱');
            $table->string('sub_company_code', 20)->nullable()->comment('券商分行代碼');
            $table->string('sub_company_name', 20)->nullable()->comment('券商分行名稱');
            $table->string('stock_code', 20)->comment('股票代碼');
            $table->string('stock_name', 20)->comment('股票名稱');
            $table->date('date')->comment('交易日期');
            $table->enum('type', ['buy', 'sell'])->comment('買賣超');
            $table->integer('buy')->default(0)->comment('買進金額');
            $table->integer('sell')->default(0)->comment('賣出金額');
            $table->integer('diff')->default(0)->comment('差額');
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->index(['company_code','sub_company_code','stock_code','date','type'],'index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_info');
    }
}
