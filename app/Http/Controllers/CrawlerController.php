<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CrawlerController extends Controller
{
   public function index(){
       self::crawler();
   }

   public static function crawler(){
    $url = "https://fubon-ebrokerdj.fbs.com.tw/z/zg/zgb/zgb0.djhtm?a=1520&b=1520";
    $response = Http::get($url);
    $body = $response->body();

    $file = mb_convert_encoding($body,"utf-8","big5");
    
    

    $all = preg_split("/\tGenLink2stk/i", $file);
    unset($all[0]);
    $final_all = [];
    foreach ($all as $info) {
        $info = preg_split("/\r\n/i", $info);
        // dd($info);
        $data_count = 0;//計算第幾個資料,0:買進金額 1:賣出金額 2:差額
        foreach ($info as  $str) {
            $find = ["('","');"];//個股
            $replace = ["",""];
            $stock_name = str_replace($find,$replace,$str);
            $stock_name = explode("','",$stock_name);
            if(isset($stock_name[0]) && isset($stock_name[1])){
                $data['code'] = $stock_name[0];//代碼
                $data['name'] = $stock_name[1];//中文
                continue;
            }
            $find =  self::findMid("nowrap>","</td>",$str);
            if($find === false){
                continue;
            }
           
            if($data_count == 0){
                $data['data1'] = $find;
            }
            if($data_count == 1){
                $data['data2'] = $find;
            }
            if($data_count == 2){
                $data['data3'] = $find;
            }
            $data_count ++;
        }
        $final_all[] = $data;

    }
    dd($final_all);
   }

   /**
    * 給頭尾找中間的值
    */
   public static function findMid($head,$foot,$str){
        $h_len = strlen($head);
        $head_pos = strpos($str,$head);
        if($head_pos === false){
            return false;
        }
        $head_pos += $h_len;
        $foot_pos = strpos($str,$foot);
        return substr( $str , $head_pos , $foot_pos - $head_pos );
   }
}
