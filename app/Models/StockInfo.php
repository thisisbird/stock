<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;

class StockInfo extends Model
{
    use SoftDeletes;
    
        protected $table = 'stock_info';

    protected $fillable = [
        'stock_code',
        'stock_name',
        'date',
        'type',
        'open',
        'high',
        'low',
        'close',
        'diff',
        'vol',
        'vol2',
        'created_at',
        'updated_at',
        'deleted_at'
    ];


}
