<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoSupplierDetail extends Model
{
    protected $table = 'po_supplier_detail';

    protected $fillable = ['pos_id', 'pr_detail_id', 'sequence_number', 'product_id', 'qty_pos', 'um_pos', 'balance_qty', 'curr', 'unit_price', 'have_external_reference', 'target_date_original', 'target_date_new', 'last_arrival_date', 'status', 'created_by', 'modified_by'];

    public $timestamps = true;
}
