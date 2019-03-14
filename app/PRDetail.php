<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PRDetail extends Model
{
    protected $table = 'purchase_request_detail';

    protected $fillable = ['pr_id ', 'sequence_number', 'type_product_id', 'product_id', 'qty_pr', 'um_pr', 'balance_qty', 'status','created_by','modified_by','created_at','updated_at'];

    public $timestamps = true;
}
