<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    protected $table = 'request_for_quotation';

    protected $fillable = ['supplier_id','termcondition', 'rfi_id', 'inquiry_customer', 'vendor_reference', 'rfq_number', 'order_date', 'supplier_contact_id', 'status', 'created_by', 'modified_by'];

    public $timestamps = true;

    /**
     * Get the contact for details.
     */
    public function details()
    {
        return $this->hasMany('App\RfqDetail', 'rfq_id');
    }
}
