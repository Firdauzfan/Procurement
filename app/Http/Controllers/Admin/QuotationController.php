<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rfq;
use App\Supplier;
use App\Quotation;
use App\QuotationDetail;
use App\SupplierContact;
use App\Items;
use Auth;
use Datatables;

class QuotationController extends Controller
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
     * Create
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $supplier = Supplier::all();
        $rfq = Rfq::all()->where('status', '0');
        $supplierContact = SupplierContact::all();

        //
        return view('admin/quotation/create')->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq );
    }

    /**
     * Save
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
    	// Parameters
    	$input = $request->all();
        $data['qs_num'] = $request->qs_num;
        $data['qs_date'] = $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->qs_date)));
        $data['rfq_id'] = $request->rfq_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['supplier_contact_id'] = $request->supplier_contact_id;
        $data['shipment_term'] = $request->shipment_term;
        $data['payment_term'] = $request->payment_term;
        $data['import_via'] = $request->import_via;
        $data['delivertime'] = $request->delivertime;
        $data['cost_freight'] = $request->cost_freight;
        $data['cost_freight_amount'] = $request->cost_freight_amount;
        $data['qs_rating'] = $request->qs_rating;
        $data['remark'] = $request->remark;
        $data['discount'] = $request->discount;
        $data['tax'] = $request->tax;
        $data['termcondition'] = $request->termcondition;
      	$data['created_by'] = Auth::user()->name;
      	$data['modified_by'] = Auth::user()->name;

        /* Handle File */

        if( !empty( $request->file('attached_file') ) ):

            $imageTempName = $request->file('attached_file')->getPathname();
            $imageName = $request->file('attached_file')->getClientOriginalName();
            //echo $imageName; die;
            $path = base_path() . '//uploads/images/';
            $request->file('attached_file')->move($path , $imageName);
            $data['attached_file'] = $imageName;
            /* /Handle File  */

        endif;

        //
    	$quotation=Quotation::create( $data );
      $rfqdone['status'] = 2;
      Rfq::where('id', $request->rfq_id)->update( $rfqdone );

      if( !empty( $request->items ) )
      {
          //ITEMS
          foreach ($request->items as $itemId => $get)
          {
              $records = Items::select('default_curr','lead_time','price_valid_until')->where( 'id', $itemId )->first();

              $quotationDetail['rfq_detail_id'] = $request->rfq_id;
              // $rfqDetail['sequence_number'] = $get["sequence_number"];
              // $rfqDetail['type_product_id'] = $get["type_product_id"];
              $quotationDetail['product_id'] = $itemId;
              $quotationDetail['qty_qs'] = $get["qty"];
              $quotationDetail['um_qs'] = $get["um"];
              $quotationDetail['status'] = 1;
              $quotationDetail['validation_needed'] = null;
              $quotationDetail['qs_id'] = $quotation->id;
              $quotationDetail['curr'] = $records->default_curr;
              $quotationDetail['unit_price'] = $get["unit_cost"];
              $quotationDetail['lead_time'] = $records->lead_time;
              $quotationDetail['price_valid_until'] = $records->price_valid_until;
              $quotationDetail['created_by'] = Auth::user()->name;
              $quotationDetail['modified_by'] = Auth::user()->name;

              //SAVE DETAIL
              $quotationdet = QuotationDetail::create( $quotationDetail );
          }
      }

    	//
    	return redirect( route('quotation_list') )->with('success', 'Quotation created');
    }

    /**
     * List
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        //
        return view('admin/quotation/list');
    }

    /**
     * Get Data
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        // Get Supplier
        $records = Quotation::query()->where('status', '0');

        return Datatables::of($records)
                ->editColumn('qs_num', function($record) {

                    return '<a href="'.route('view_quotation', $record->id).'"">
                        #'.$record->qs_num.'
                    </a>';
                })
                ->editColumn('approved', function($record) {

                    return $record->approved ? "Approved" : "Not Approved";
                })
                ->editColumn('approved_by', function($record) {

                    return $record->approved_by;
                })
                ->editColumn('supplier_id', function($record) {

                    $supplier = Supplier::select('supplier_name')->where( 'id', $record->supplier_id )->first();
                    return $supplier->supplier_name;
                })
                ->editColumn('supplier_contact_id', function($record) {

                    $contact = SupplierContact::select('contact_name')->where( 'id', $record->supplier_contact_id )->first();
                    return $contact->contact_name;
                })
                ->editColumn('shipment_term', function($record) {

                    return $record->shipment_term;
                })
                ->editColumn('import_via', function($record) {

                    if( $record->import_via == 0 )
                    {
                        return 'Local';
                    }
                    if( $record->import_via == 1 )
                    {
                        return 'Air';
                    }
                    if( $record->import_via == 2 )
                    {
                        return 'Sea';
                    }
                })
                ->editColumn('cost_freight', function($record) {

                    if( $record->cost_freight == 0 )
                    {
                        return 'Paid';
                    }
                    if( $record->cost_freight == 1 )
                    {
                        return 'Not Paid';
                    }
                })
                ->editColumn('action', function($record) {

                    return '

                        &nbsp&nbsp

                        <a href="'.route('view_quotation', $record->id).'"">
                            <img class="view-action" src="'.asset("/admin/images/view.png").'">
                        </a>

                        &nbsp&nbsp&nbsp&nbsp&nbsp

                        <a href="'.route('delete_quotation', $record->id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                            <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                        </a>

                    ';
                })
                ->rawColumns(['qs_num','id', 'action'])

            ->make(true);
    }

    /**
     * Delete
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        //
        $quotedel['status'] = 1;
        Quotation::where('id', $id)->update( $quotedel );
        // Quotation::destroy( $id );

        //
        return redirect( route('quotation_list') )->with('success', 'Quotation deleted!');
    }

    /**
     * View
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        //
        $supplier = Supplier::all();
        $supplierContact = SupplierContact::all();
        $rfq = Rfq::all();
        $dataall = Quotation::all();
        $data = Quotation::find( $id );

        //
        return view('admin/quotation/view')->with( 'data', $data )->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq )->with( 'dataall', $dataall );
    }

    public function viewApprove(Request $request, $id)
    {
        //
        $supplier = Supplier::all();
        $supplierContact = SupplierContact::all();
        $rfq = Rfq::all();
        $dataall = Quotation::all();
        $data = Quotation::find( $id );

        //
        return view('admin/quotation/viewapprove')->with( 'data', $data )->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq )->with( 'dataall', $dataall );
    }

    /**
     * Save
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Parameters
        $input = $request->all();
        $id = $request->id;
        $data['qs_num'] = $request->qs_num;
        $data['qs_date'] = $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->qs_date)));
        $data['rfq_id'] = $request->rfq_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['supplier_contact_id'] = $request->supplier_contact_id;
        $data['shipment_term'] = $request->shipment_term;
        $data['payment_term'] = $request->payment_term;
        $data['import_via'] = $request->import_via;
        $data['cost_freight'] = $request->cost_freight;
        $data['cost_freight_amount'] = $request->cost_freight_amount;
        $data['qs_rating'] = $request->qs_rating;
        $data['remark'] = $request->remark;
        $data['discount'] = $request->discount;
        $data['tax'] = $request->tax;
        $data['delivertime'] = $request->delivertime;

        $data['status'] = $request->status;
        $data['created_by'] = Auth::user()->name;
        $data['modified_by'] = Auth::user()->name;

        /* Handle File */

        // if( !empty( $request->file('attached_file') ) ):
        //
        //     $imageTempName = $request->file('attached_file')->getPathname();
        //     $imageName = $request->file('attached_file')->getClientOriginalName();
        //     //echo $imageName; die;
        //     $path = base_path() . '//uploads/images/';
        //     $request->file('attached_file')->move($path , $imageName);
        //     $data['attached_file'] = $imageName;
        //     /* /Handle File  */
        //
        // endif;

        //
        Quotation::where('id', $id)->update( $data );

        if( !empty( $request->items ) )
        {
            //ITEMS
            foreach ($request->items as $itemId => $get)
            {
                // $rfqDetail['sequence_number'] = $get["sequence_number"];
                // $rfqDetail['type_product_id'] = $get["type_product_id"];
                $quotationDetail['qty_qs'] = $get["qty"];
                $quotationDetail['um_qs'] = $get["um"];
                $quotationDetail['status'] = 1;
                $quotationDetail['unit_price'] = $get["unit_cost"];
                $quotationDetail['modified_by'] = Auth::user()->name;

                //SAVE DETAIL
                $quotationdet = QuotationDetail::where('qs_id', $id)->where('product_id', $itemId)->update( $quotationDetail );
            }
        }
        //
        return redirect( route('quotation_list') )->with('success', 'Quotation updated!');
    }

    public function approve()
    {
        return view('admin/quotation/approve');
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
            Quotation::where('id', $id)->update( $data );

            //
            return redirect( route('view_quotation_approve',$id) )->with('success', 'Quotation aprroved!');
        }
        else
        {
            // Parameters
            $data['rejected'] = 1;
            $data['approved'] = 0;
            $data['reject_reason'] = $request->reason;
            $data['approved_by'] = Auth::user()->name;

            //
            Quotation::where('id', $request->id)->update( $data );

            //
            return redirect( route('view_quotation_approve',$request->id) )->with('success', 'Quotation rejected!');
        }

        //

    }

    public function getApproveData($dataid)
    {
        // Get Supplier
        $records = Quotation::query()->whereIn( 'id', explode( ',', $dataid ) );

        return Datatables::of($records)
                ->editColumn('qs_num', function($record) {

                    return '<a href="'.route('view_quotation_approve', $record->id).'"">
                        #'.$record->qs_num.'
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

                      <a href="'.route('quotation_approve_status_approve', array($record->id, 'approve')).'">
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
                ->rawColumns(['qs_num','id', 'action'])

            ->make(true);
    }

    public function getApproveData2(Request $request)
    {
        // Get Supplier
        $records = Quotation::query();


        return Datatables::of($records)
                ->editColumn('qs_num', function($record) {

                    return '<a href="'.route('view_quotation_approve', $record->id).'"">
                        #'.$record->qs_num.'
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
                ->rawColumns(['qs_num','id', 'action'])

            ->make(true);
    }
}
