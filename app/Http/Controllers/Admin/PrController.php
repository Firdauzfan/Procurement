<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rfq;
use App\Rfi;
use App\Supplier;
use App\Quotation;
use App\SupplierContact;
use App\PurchaseOrder;
use App\PoSupplierDetail;
use App\Items;
use App\PurchaseRequest;
use App\PRDetail;
use App\PrTerm;
use Auth;
use Datatables;

class PrController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      //
      $purchase_request = PurchaseRequest::all();
      $supplier = Supplier::all();
      $supplierContact = SupplierContact::all();
      $dataall = Quotation::all()->where('status', '0');
      $rfi = Rfi::all();

      //
      return view('admin/purchase_request/create')->with( 'suppliers', $supplier )->with( 'dataall', $dataall )->with( 'supplierContacts', $supplierContact )->with( 'rfi', $rfi )->with( 'purchase_request', $purchase_request );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $input = $request->all();
        $data['pr_number'] = $request->pr_number;
        $data['qs_id'] = $request->qs_num;
        $data['request_from'] = $request->request_from;
        $data['purpose'] = $request->purpose;
        $data['purpose_remark'] = $request->purpose_remark;
        $data['request_mode'] = $request->request_mode;
        $data['pr_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->pr_date)));
        // $data['status'] = 1;
        $data['created_by'] = Auth::user()->name;
        $data['modified_by'] = Auth::user()->name;

        //SAVE PR
        $prquest=PurchaseRequest::create( $data );
        $Quotationdone['status'] = 2;
        Quotation::where('id', $request->qs_num)->update( $Quotationdone );


        //DETAIL
        if( !empty( $request->items ) )
        {
            //ITEMS
            foreach ($request->items as $itemId => $get)
            {
                $prDetail['sequence_number'] = null;
                $prDetail['type_product_id'] = null;
                $prDetail['product_id'] = $itemId;
                $prDetail['qty_pr'] = $get["qty"];
                $prDetail['um_pr'] = $get["um"];
                $prDetail['status'] = 1;
                $prDetail['balance_qty'] = null;
                $prDetail['pr_id'] = $prquest->id;
                $prDetail['created_by'] = Auth::user()->name;
                $prDetail['modified_by'] = Auth::user()->name;

                //SAVE DETAIL
                $prdet = PRDetail::create( $prDetail );

            }
            if ($request->qs_num == '0') {

                $data = PrTerm::where('created_by', Auth::user()->name);
                $data->delete();
            }
        }

      return redirect( route('purchase_request_list') )->with('success', 'Purchase Request created');
    }

    public function saveItemData(Request $request)
    {
        //echo '<pre>';
        //print_r( $request->all() );
        //die();
    	// Parameters
    	  $input = $request->all();
        $data['product_id'] = $request->product_id;
        $data['qty_qs'] = $request->qty_rfi;
        $data['um_qs'] = $request->um_rfi;

        $data['status'] = 2;
      	$data['created_by'] = Auth::user()->name;

        //SAVE RFQ
        $qsdet = PrTerm::create( $data );

    	//
    	return redirect( route('create_purchase_request') )->with('success', 'Add Item Success');
    }

    public function saveItemDataUpdate(Request $request)
    {
        //echo '<pre>';
        //print_r( $request->all() );
        //die();
    	// Parameters
    	  $input = $request->all();
        $id=$request->id;
        $data['pr_id'] = $request->id;
        $data['product_id'] = $request->product_id;
        $data['qty_pr'] = $request->qty_rfq;
        $data['um_pr'] = $request->um_rfq;

      	$data['created_by'] = Auth::user()->name;
        $data['modified_by'] = Auth::user()->name;
        //SAVE RFQ
        $prdet = PrDetail::create( $data );

    	//
    	return redirect( route('view_purchase_request',$id) )->with('success', 'Add Item Success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */

    public function list(Request $request)
    {
        //
        return view('admin/purchase_request/list');
    }

    /**
     * Get Data
     *
     * @return \Illuminate\Http\Response
     */

    public function getData(Request $request)
    {
        // Get Supplier
        $records = PurchaseRequest::query()->where('status', '0');


        return Datatables::of($records)
                ->editColumn('pr_number', function($record) {

                    $prsql= PurchaseRequest::select('pr_number')->where( 'pr_number', $record->pr_number )->first();
                    return '<a href="'.route('view_purchase_request', $record->id).'"">
                        '.$prsql->pr_number.'
                        </a>';
                })
                ->editColumn('request_mode', function($record) {

                    return $record->request_mode ? "Routine" : "Not Routine";
                })
                ->editColumn('approved', function($record) {

                    return $record->approved ? "Approved" : "Not Approved";
                })
                ->editColumn('approved_by', function($record) {

                    return $record->approved_by;
                })
                ->editColumn('action', function($record) {

                    return '

                        &nbsp&nbsp

                        <a href="'.route('view_purchase_request', $record->id).'"">
                            <img class="view-action" src="'.asset("/admin/images/view.png").'">
                        </a>

                        &nbsp&nbsp&nbsp&nbsp&nbsp

                        <a href="'.route('delete_purchase_request', $record->id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                            <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                        </a>

                    ';
                })
                ->rawColumns(['pr_number', 'action'])

            ->make(true);
    }

    public function delete(Request $request, $id)
    {
        //
        // PurchaseRequest::destroy( $id );
        $prdel['status'] = 1;
        PurchaseRequest::where('id', $id)->update( $prdel );

        //
        return redirect( route('purchase_request_list') )->with('success', 'Purchase Request deleted!');
    }

    public function view(Request $request, $id)
    {
        //
        $supplier = Supplier::all();
        $supplierContact = SupplierContact::all();
        $rfq = Rfq::all();
        $dataall = PurchaseRequest::all();
        $data = PurchaseRequest::find( $id );
        $qsdata = Quotation::all();

        //
        return view('admin/purchase_request/view')->with( 'qsdata', $qsdata )->with( 'data', $data )->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq )->with( 'dataall', $dataall );
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      // Parameters
      $input = $request->all();

      $id = $request->id;
      $input = $request->all();
      $data['pr_number'] = $request->pr_number;
      $data['request_from'] = $request->request_from;
      $data['purpose'] = $request->purpose;
      $data['pr_date'] = $request->pr_date;
      $data['request_mode'] = $request->request_mode;
      $data['purpose_remark'] = $request->purpose_remark;
      $data['created_by'] = Auth::user()->name;
      $data['modified_by'] = Auth::user()->name;

      PurchaseRequest::where('id', $id)->update( $data );

      //
      return redirect( route('purchase_request_list') )->with('success', 'Purchase Request updated!');
    }


      public function approve()
      {
          return view('admin/purchase_request/approve');
      }


      public function viewApprove(Request $request, $id)
      {
          //
          $supplier = Supplier::all();
          $supplierContact = SupplierContact::all();
          $rfq = Rfq::all();
          $dataall = PurchaseRequest::all();
          $data = PurchaseRequest::find( $id );

          //
          return view('admin/purchase_request/viewapprove')->with( 'data', $data )->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq )->with( 'dataall', $dataall );
      }
      /**
       * Approve
       *
       * @return \Illuminate\Http\Response
       */
      public function approveStatus( $id = null, $status = null, Request $request )
      {
          if( $status == "approve" )
          {

              // Parameters
              $data['approved'] = 1;
              $data['rejected'] = 0;
              $data['reject_reason'] = '';
              $data['approved_by'] = Auth::user()->name;

              //
              PurchaseRequest::where('id', $id)->update( $data );

              //
              return redirect( route('view_purchase_request_approve',$id) )->with('success', 'Purchase Request aprroved!');
          }
          else
          {
              // Parameters
              $data['rejected'] = 1;
              $data['approved'] = 0;
              $data['reject_reason'] = $request->reason;
              $data['approved_by'] = Auth::user()->name;

              //
              PurchaseRequest::where('id', $request->id)->update( $data );

              //
              return redirect( route('view_purchase_request_approve',$request->id) )->with('success', 'Purchase Request rejected!');
          }

          //

      }

      public function getApproveData($dataid)
      {
          // Get Supplier
          $records = PurchaseRequest::query()->whereIn( 'id', explode( ',', $dataid ) );

          return Datatables::of($records)
                  ->editColumn('pr_number', function($record) {

                      return '<a href="'.route('view_purchase_request_approve', $record->id).'"">
                          #'.$record->pr_number.'
                      </a>';
                  })
                  ->editColumn('approved', function($record) {

                      return $record->approved ? "Approved" : "Not Approved";
                  })
                  ->editColumn('approved_by', function($record) {

                      return $record->approved_by;
                  })
                  ->editColumn('created_at', function($record) {

                      return $record->created_at;
                  })
                  ->editColumn('action', function($record) {
                    return '

                        &nbsp&nbsp

                        <a href="'.route('purchase_request_approve_status_approve', array($record->id, 'approve')).'">
                            <button type="button" class="btn btn-success">
                                '. ( $record->approved ? "Approved" : "Approve" ) .'
                            </button>
                        </a>

                        &nbsp&nbsp&nbsp&nbsp&nbsp

                        <a data-toggle="modal" onClick="reject(\''.trim($record->id).'\',\''.( $record->rejected ? "Rejected" : "Reject" ).'\')" data-target="'. ( $record->rejected ? "" : "#myModal" ) .'">
                            <button type="button" class="btn btn-warning">
                            '. ( $record->rejected ? "Rejected" : "Reject" ) .'
                            </button>
                        </a>

                    ';

                  })
                  ->editColumn('reason', function($record) {

                      return ( $record->rejected ? $record->reject_reason : "N/A" );
                  })
                  ->rawColumns(['pr_number','id', 'action'])

              ->make(true);
      }

      public function deleteItemDataTable(Request $request, $id)
      {
          $data = PrTerm::where('id',$id);
          $data->delete();
          // $data['status'] = 2;
          // RfiDetail::destroy( $data );

          return redirect( route('create_purchase_request') )->with('success', 'Cancel Item Success');
      }

      public function deleteItemDataTable2(Request $request, $id)
      {
          $data = PrDetail::where('id',$id);
          $data->delete();
          // $data['status'] = 2;
          // RfiDetail::destroy( $data );

          return redirect( route('purchase_request_list') )->with('success', 'Delete Item Success');
      }

      public function getApproveData2(Request $request)
      {
          // Get Supplier
          $records = PurchaseRequest::query();


          return Datatables::of($records)
                  ->editColumn('pr_number', function($record) {

                      return '<a href="'.route('view_purchase_request_approve', $record->id).'"">
                          #'.$record->pr_number.'
                      </a>';
                  })
                  ->editColumn('approved', function($record) {

                      return $record->approved ? "Approved" : "Not Approved";
                  })
                  ->editColumn('approved_by', function($record) {

                      return $record->approved_by;
                  })
                  ->editColumn('created_at', function($record) {

                      return $record->created_at;
                  })
                  ->editColumn('action', function($record) {
                    // return '
                    //
                    //     &nbsp&nbsp
                    //
                    //     <a href="'.route('quotation_approve_status_approve', array($record->id, 'approve')).'">
                    //         <button type="button" class="btn btn-success">
                    //             '. ( $record->approved ? "Approved" : "Approve" ) .'
                    //         </button>
                    //     </a>
                    //
                    //     &nbsp&nbsp&nbsp&nbsp&nbsp
                    //
                    //     <a data-toggle="modal" onClick="reject(\''.trim($record->id).'\',\''.( $record->rejected ? "Rejected" : "Reject" ).'\')" data-target="'. ( $record->rejected ? "" : "#myModal" ) .'">
                    //         <button type="button" class="btn btn-warning">
                    //         '. ( $record->rejected ? "Rejected" : "Reject" ) .'
                    //         </button>
                    //     </a>
                    //
                    // ';
                      return '

                          &nbsp&nbsp

                          <a href="#">
                              <button type="button" class="btn btn-success">
                                  '. ( $record->approved ? "Approved" : "Approve" ) .'
                              </button>
                          </a>

                          &nbsp&nbsp&nbsp&nbsp&nbsp

                          <a data-toggle="modal"">
                              <button type="button" class="btn btn-warning">
                              '. ( $record->rejected ? "Rejected" : "Reject" ) .'
                              </button>
                          </a>

                      ';
                  })
                  ->editColumn('reason', function($record) {

                      return ( $record->rejected ? $record->reject_reason : "N/A" );
                  })
                  ->rawColumns(['pr_number','id', 'action'])

              ->make(true);
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
