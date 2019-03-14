<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rfi extends Model
{
    protected $table = 'request_for_inquiry';


    public $timestamps = true;

    /**
     * Get the contact for details.
     */
    public function details()
    {
        return $this->hasMany('App\RfiDetail', 'rfi_id');
    }
}
