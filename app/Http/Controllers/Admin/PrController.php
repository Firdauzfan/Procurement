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
      $rfi = Rfi::all();

      //
      return view('admin/purchase_request/create')->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfi', $rfi )->with( 'purchase_request', $purchase_request );
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
        $data['request_from'] = $request->request_from;
        $data['purpose'] = $request->purpose;
        $data['purpose_remark'] = $request->purpose_remark;
        $data['request_mode'] = $request->request_mode;
        $data['pr_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->pr_date)));
        // $data['status'] = 1;
        $data['created_by'] = Auth::user()->name;
        $data['modified_by'] = Auth::user()->name;

        //SAVE PR
        PurchaseRequest::create( $data );

        // //TRUNCATE DETAIL
        // PurchaseRequest::where('pr_id', $purchase_request->id)->truncate();
        //
        // //DETAIL
        // if( !empty( $request->items ) )
        // {
        //     //ITEMS
        //     foreach ($request->items as $itemId => $get)
        //     {
        //         $prDetail['sequence_number'] = null;
        //         $prDetail['type_product_id'] = null;
        //         $prDetail['product_id'] = $itemId;
        //         $prDetail['qty_pr'] = $get["qty_pr"];
        //         $prDetail['um_pr'] = $get["um_pr"];
        //         $prDetail['status'] = 1;
        //         $prDetail['balance_qty '] = null;
        //         $prDetail['created_by'] = Auth::user()->name;
        //         $prDetail['modified_by'] = Auth::user()->name;
        //
        //         //SAVE DETAIL
        //         $prDetail['pr_id'] = $purchase_request->pr_id;
        //         PurchaseRequest::create( $prDetail );
        //     }
        // }

      //
      return redirect( route('purchase_request_list') )->with('success', 'Purchase Request created');
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
        $records = PurchaseRequest::query();


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
        PurchaseRequest::destroy( $id );

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

        //
        return view('admin/purchase_request/view')->with( 'data', $data )->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq )->with( 'dataall', $dataall );
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

      // Parameters

      // $rfqDetail['rfi_detail_id'] = $request->rfi_detail_id;
      // $rfqDetail['sequence_number'] = $request->sequence_number;
      // $rfqDetail['type_product_id'] = $request->type_product_id;
      // $rfqDetail['product_id'] = $request->product_id;
      // $rfqDetail['qty_rfq'] = $request->qty_rfq;
      // $rfqDetail['um_rfq'] = $request->um_rfq;
      // $rfqDetail['status'] = $request->rfq_detail_status;
      // $rfqDetail['validation_needed'] = $request->validation_needed;

      //
      PurchaseRequest::where('id', $id)->update( $data );
      // RfqDetail::where('rfq_id', $id)->update( $rfqDetail );

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

      public function getApproveData(Request $request)
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
