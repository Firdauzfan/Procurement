<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RfiDetail extends Model
{
    protected $table = 'rfi_detail';

    protected $fillable = ['rfi_id', 'sequence_number', 'type_product_id', 'qty_rfi', 'um_rfi','product_id','status','created_by', 'modified_by'];

    public $timestamps = true;
}
