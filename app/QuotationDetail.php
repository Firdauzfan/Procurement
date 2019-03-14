<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $table = 'quotation_supplier_detail';

    protected $fillable = ['qs_id','rfq_detail_id', 'sequence_no', 'type_product_id', 'product_id', 'qty_qs', 'um_qs', 'curr', 'unit_price','lead_time','price_valid_until','status','validated','validated_by','validated_date','approved','approved_by','approved_date','created_by','modified_by','created_at',
    'updated_at'];

    public $timestamps = true;
}
