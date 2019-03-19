<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rfi extends Model
{
    protected $table = 'request_for_inquiry';

    protected $fillable = ['id', 'rfi_dept_id', 'rfi_requester_id', 'customer_id', 'status', 'created_by', 'modified_by', 'created_at', 'updated_at'];

    public $timestamps = true;

    /**
     * Get the contact for details.
     */
    public function details()
    {
        return $this->hasMany('App\RfiDetail', 'rfi_id');
    }
}
