<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'quotation_supplier';

    protected $fillable = ['qs_num', 'qs_date', 'rfq_id', 'supplier_id', 'supplier_contact_id', 'shipment_term', 'payment_term', 'import_via', 'cost_freight', 'cost_freight_amount', 'qs_rating', 'remark', 'attached_file', 'status', 'created_by', 'modified_by', 'delivertime','discount', 'tax'];

    public $timestamps = true;

    public function details()
    {
        return $this->hasMany('App\QuotationDetail', 'qs_id');
    }
}
