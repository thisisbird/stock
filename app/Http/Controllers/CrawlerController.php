<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\TransactionInfo;
class CrawlerController extends Controller
{
    public function index()
    {
        self::crawler();
    }

    public static function crawler()
    {
        $today = date('Y-m-d');
        $count = TransactionInfo::where('date',$today)->count();
        if($count > 0)
        {
            return '今日資料已寫入!';
        }
        $company = TransactionInfo::COMPANY;
        $sub_company = TransactionInfo::getSubCompany();
        sleep(2);
        foreach($company as $key=>$val)
        {
            foreach($sub_company[$key] as $sub_key=>$sub_val)
            {
                $url = "https://fubon-ebrokerdj.fbs.com.tw/z/zg/zgb/zgb0.djhtm?a=".$key."&b=".$sub_key;
                $response = Http::get($url);
                $body = $response->body();

                $file = mb_convert_encoding($body, "utf-8", "big5");
                $all = preg_split("/\tGenLink2stk/i", $file);
                unset($all[0]);
                $final_all = [];

                foreach ($all as $info) {
                    $info = preg_split("/\r\n/i", $info);
                    // dd($info);
                    $data_count = 0; //計算第幾個資料,0:買進金額 1:賣出金額 2:差額
                    foreach ($info as $str) {
                        $find = ["('", "');"]; //個股
                        $replace = ["", ""];
                        $stock_name = str_replace($find, $replace, $str);
                        $stock_name = explode("','", $stock_name);
                        if (isset($stock_name[0]) && isset($stock_name[1])) {
                            $data['code'] = substr($stock_name[0], 0, 2) == 'AS' ? substr($stock_name[0], 2, 6) : $stock_name[0]; //代碼
                            $data['name'] = $stock_name[1]; //中文
                            continue;
                        }
                        $find = self::findMid("nowrap>", "</td>", $str);

                        $find2 = self::findMid(';">', "</a>", $str);
                        if ($find2 !== false) //例外狀況
                        {
                            $final_all[] = $data; //先把第一組放進去
                            $find2 = (preg_split('/(?<!\p{Latin})(?=\p{Latin})|(?<!\p{Han})(?=\p{Han})|(?<![0-9])(?=[0-9])/u', $find2, -1, PREG_SPLIT_NO_EMPTY)); // Test 中文數字 1000 切割測試
                            $data['code'] = $find2[0]; //代碼
                            $data['name'] = $find2[1]; //中文
                            $data_count = 0;
                            continue;
                        }

                        if ($find === false) {
                            continue;
                        }

                        if ($data_count == 0) {
                            $data['data1'] = str_replace(',','',$find);
                        }
                        if ($data_count == 1) {
                            $data['data2'] = str_replace(',','',$find);
                        }
                        if ($data_count == 2) {
                            $data['data3'] = str_replace(',','',$find);
                        }
                        $data_count++;
                    }

                    $db = new TransactionInfo();
                    $db->company_code = $key;
                    $db->company_name = $val;
                    $db->sub_company_code = $sub_key;
                    $db->sub_company_name = $sub_val;
                    $db->stock_code = $data['code'];
                    $db->stock_name = $data['name'];
                    $db->date = $today;
                    $db->type = $data['data3'] > 0?'buy':'sell';
                    $db->buy = $data['data1'];
                    $db->sell = $data['data2'];
                    $db->diff = $data['data3'];
                    $db->save();
                }
                sleep(2);
            }
        }
    }

    /**
     * 給頭尾找中間的值
     */
    public static function findMid($head, $foot, $str)
    {
        $head_pos = strpos($str, $head);
        if ($head_pos === false) {
            return false;
        }
        $foot_pos = strpos($str, $foot);
        if ($foot_pos === false) {
            return false;
        }
        $h_len = strlen($head);
        $head_pos += $h_len;
        return substr($str, $head_pos, $foot_pos - $head_pos);
    }
}
