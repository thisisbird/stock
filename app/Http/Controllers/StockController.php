<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StockInfo;
class StockController extends Controller
{
    public $ma_temp = [];
    
    public function index()
    {
        $all_stocks = StockInfo::pluck('stock_name','stock_code');
        $can_buy = [];
        foreach ($all_stocks as $code=>$name) {
            $this->ma_temp = [];
            $last_day_info = $this->oneStock($code);
            
            if($last_day_info->good){
                $can_buy[] = $last_day_info;
            }
        }
        return $can_buy;
    }

    function oneStock($code){
        $stock_info = StockInfo::where('stock_code',$code)->orderBy('date')->get();
        foreach ($stock_info as $i => $day_info) {
            $day_info->ma5 = $this->ma($day_info->close,5);
            $day_info->ma20 = $this->ma($day_info->close,20);
            $day_info->ma60 = $this->ma($day_info->close,60);

            if($i+1 == $stock_info->count()){//判斷最後一天
                $day_info->lastday = true;
                if($day_info->ma5 > $day_info->ma20 && $day_info->ma20 > $day_info->ma60){//多頭排列
                    $day_info->good = true;
                }
                return $day_info;
            }
        }
       return null;
    }
    /**
     * 計算平均線
     * close 價錢
     * count 幾根
     */
    function ma($close,$count){
        $this->ma_temp[$count][] = $close;
        if(count($this->ma_temp[$count]) < $count){
            return 0;
        }
        if(count($this->ma_temp[$count]) > $count){
            unset($this->ma_temp[$count][0]);
            $this->ma_temp[$count] = array_values($this->ma_temp[$count]);
        }
        return array_sum($this->ma_temp[$count])/$count;
    }

    public function kline(){
        return view('kline');
    }
}
