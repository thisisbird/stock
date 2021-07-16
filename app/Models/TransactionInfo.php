<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;

class TransactionInfo extends Model
{
    use SoftDeletes;

    const COMPANY = [
            "6010"=>"(牛牛牛)亞證券",
            "1030"=>"土銀",
            "8890"=>"大和國泰",
            "6460"=>"大昌",
            "5050"=>"大展",
            // "8770"=>"大鼎(停)",
            "5260"=>"大慶",
            "6160"=>"中國信託",
            "8520"=>"中農",
            "9800"=>"元大",
            "2200"=>"元大期貨",
            "5920"=>"元富",
            "5960"=>"日茂",
            "1160"=>"日盛",
            "5660"=>"日進",
            "7750"=>"北城",
            "6110"=>"台中銀",
            "7120"=>"台安",
            "8150"=>"台新",
            "3000"=>"台新銀",
            "1090"=>"台灣工銀",
            "8910"=>"台灣巴克萊",
            "1110"=>"台灣企銀",
            "1380"=>"台灣匯立證券",
            "1470"=>"台灣摩根士丹利",
            "6450"=>"永全",
            "5600"=>"永興",
            "9A00"=>"永豐金",
            "8840"=>"玉山",
            "7080"=>"石橋",
            "6380"=>"光和",
            "7000"=>"兆豐",
            "6620"=>"全泰",
            "1020"=>"合庫",
            "8380"=>"安泰",
            "1260"=>"宏遠",
            "2180"=>"亞東",
            "6660"=>"和興",
            "8900"=>"法銀巴黎",
            "8700"=>"花旗",
            "1590"=>"花旗環球",
            "7690"=>"金興",
            "5860"=>"盈溢",
            "1440"=>"美林",
            "1480"=>"美商高盛",
            "7030"=>"致和",
            "8960"=>"香港上海匯豐",
            "5320"=>"高橋",
            "8880"=>"國泰",
            "7790"=>"國票",
            "8450"=>"康和",
            "5380"=>"第一金",
            "5850"=>"統一",
            "9200"=>"凱基",
            "9600"=>"富邦",
            "5110"=>"富隆",
            "7530"=>"富順",
            "1570"=>"港商法國興業",
            "1560"=>"港商野村",
            "1360"=>"港商麥格理",
            "1530"=>"港商德意志(停)",
            "1660"=>"港商聯昌",
            "1400"=>"港商蘇皇",
            "6640"=>"渣打商銀",
            "9300"=>"華南永昌",
            "8710"=>"陽信",
            "1650"=>"新加坡商瑞銀",
            "8560"=>"新光",
            "6210"=>"新百王",
            "8690"=>"新壽",
            "1520"=>"瑞士信貸",
            "8490"=>"萬泰",
            "8660"=>"萬通(停)",
            "9100"=>"群益金鼎",
            "2210"=>"群益期貨",
            "1230"=>"彰銀",
            "6480"=>"福邦",
            "6950"=>"福勝",
            "1040"=>"臺銀",
            "6910"=>"德信",
            "8440"=>"摩根大通",
            "8580"=>"聯邦商銀",
            "7070"=>"豐農",
            "5500"=>"豐銀",
            "7900"=>"豐德",
            "5690"=>"豐興",
            "5460"=>"寶盛"
        ];

    protected $table = 'transaction_info';

    protected $fillable = [
        'company_code',
        'company_name',
        'sub_company_code',
        'sub_company_name',
        'stock_code',
        'stock_name',
        'date',
        'type',
        'buy',
        'sell',
        'diff',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    static function getSubCompany()
    {
        $company = self::COMPANY;
        $result = [];
        $response = Http::get("https://fubon-ebrokerdj.fbs.com.tw/z/js/zbrokerjs.djjs");
        $body = $response->body();
        $file = mb_convert_encoding($body, "utf-8", "big5");
        $all = preg_split("/\n/",$file);
        $str = trim(str_replace("'",'',str_replace('var g_BrokerList =','',$all[0])));
        $arr = explode(';',$str);
        foreach($company as $key=>$val)
        {
            foreach($arr as $arr1)
            {
                if(!empty($arr1))
                {
                    $arr2 = explode('!',$arr1);
                    $compare = explode(',',$arr2[0]);
                    if($key == $compare[0])
                    {
                        foreach($arr2 as $arr3)
                        {
                            $arr4 = explode(',',$arr3);
                            $result[$key][$arr4[0]] = $arr4[1];
                        }
                    }
                }
            }
        }

        return $result;
    }
}
