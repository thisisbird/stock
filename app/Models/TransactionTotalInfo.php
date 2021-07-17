<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionTotalInfo extends Model
{
    use SoftDeletes;

    protected $table = 'transaction_total_info';

    protected $fillable = [
        'company_code',
        'company_name',
        'sub_company_code',
        'sub_company_name',
        'date',
        'type',
        'buy',
        'sell',
        'diff',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
