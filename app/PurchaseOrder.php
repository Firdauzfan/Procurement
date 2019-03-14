<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'po_supplier';

    protected $fillable = ['po_number','pr_id', 'rfq_id', 'supplier_id', 'supplier_contact_id', 'shipment_term', 'payment_term', 'import_via', 'cost_freight', 'cost_freight_amount', 'vat', 'qs_rating', 'remark', 'attached_file', 'status', 'invoice_status', 'pos_supplier_rating', 'approved', 'approved_by', 'approved_date', 'created_by', 'modified_by'];

    public $timestamps = true;
}
