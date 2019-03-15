<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
  protected $table = 'purchase_request';

  protected $fillable = ['id','pr_number','qs_id','pr_date','request_from','request_mode','pr_dept', 'pr_reference_type ', 'pr_reference_id ', 'pr_requester_id ','purpose','purpose_remark', 'status', 'approved_by', 'approved_date', 'created_by', 'modified_by', 'created_at', 'updated_at'];

  public $timestamps = true;

  public function details()
  {
      return $this->hasMany('App\PRDetail', 'pr_id');
  }
}
