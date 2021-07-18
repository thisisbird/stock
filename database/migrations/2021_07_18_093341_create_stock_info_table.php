<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_info', function (Blueprint $table) {
            $table->id();
            $table->string('stock_code', 20)->comment('股票代碼');
            $table->string('stock_name', 20)->comment('股票名稱');
            $table->date('date')->comment('交易日期');
            $table->string('type')->comment('漲跌');
            $table->decimal('open', 7, 2)->default(0);
            $table->decimal('high', 7, 2)->default(0);
            $table->decimal('low', 7, 2)->default(0);
            $table->decimal('close', 7, 2)->default(0);
            $table->decimal('diff', 7, 2)->default(0)->comment('漲跌價');
            $table->integer('vol2')->default(0)->comment('成交股數');
            $table->integer('vol')->default(0)->comment('成交筆數');
            $table->bigInteger('price')->default(0)->comment('成交金額');
            $table->datetime('created_at')->useCurrent();
            $table->datetime('updated_at')->nullable();
            $table->datetime('deleted_at')->nullable();
            $table->index(['stock_code','stock_name','date','type'],'index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_info');
    }
}
