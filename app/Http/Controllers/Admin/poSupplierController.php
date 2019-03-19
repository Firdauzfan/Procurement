<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Rfq;
use App\Supplier;
use App\Quotation;
use App\SupplierContact;
use App\PurchaseOrder;
use App\PoSupplierDetail;
use App\PurchaseRequest;
use App\Items;
use Auth;
use Datatables;

class poSupplierController extends Controller
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
        $data=PurchaseOrder::all();
        $supplier = Supplier::all();
        $rfq = Rfq::all();
        $supplierContact = SupplierContact::all();
        $pr = PurchaseRequest::all()->where('status', '0');

        //
        return view('admin/purchase_order/create')->with( 'pr', $pr )->with( 'suppliers', $supplier )->with( 'data', $data )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq );
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
        $data['po_number'] = $request->po_number;
        $data['pr_id'] = $request->pr_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['supplier_contact_id'] = $request->supplier_contact_id;
        $data['shipment_term'] = $request->shipment_term;
        $data['payment_term'] = $request->payment_term;
        $data['import_via'] = $request->import_via;
        $data['cost_freight'] = $request->cost_freight;
        $data['cost_freight_amount'] = $request->cost_freight_amount;
        $data['vat'] = $request->vat;
        $data['qs_rating'] = $request->qs_rating;
        $data['remark'] = $request->remark;
        //$data['attached_file'] = $request->attached_file;
        $data['invoice_status'] = $request->invoice_status;
        $data['pos_supplier_rating'] = $request->pos_supplier_rating;
        $data['approved'] = ( isset( $input['approved'] ) ? 1 : 0 );
        $data['approved_by'] = $request->approved_by;
        // $data['approved_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->approved_date)));
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
    	$Po=PurchaseOrder::create( $data );
      $Purchaserequestdone['status'] = 2;
      PurchaseRequest::where('id', $request->pr_id)->update( $Purchaserequestdone );

      if( !empty( $request->items ) )
      {
          //ITEMS
          foreach ($request->items as $itemId => $get)
          {
              $records = Items::select('default_curr','lead_time','price_valid_until')->where( 'id', $itemId )->first();

              $poDetail['pr_detail_id'] = $request->pr_id;
              // $rfqDetail['sequence_number'] = $get["sequence_number"];
              // $rfqDetail['type_product_id'] = $get["type_product_id"];
              $poDetail['product_id'] = $itemId;
              $poDetail['qty_pos'] = $get["qty"];
              $poDetail['um_pos'] = $get["um"];
              $poDetail['status'] = 1;
              $poDetail['validation_needed'] = null;
              $poDetail['pos_id'] = $Po->id;
              $poDetail['curr'] = $records->default_curr;
              $poDetail['unit_price'] = $get["unit_cost"];
              $poDetail['lead_time'] = $records->lead_time;
              $poDetail['price_valid_until'] = $records->price_valid_until;
              $poDetail['created_by'] = Auth::user()->name;
              $poDetail['modified_by'] = Auth::user()->name;

              //SAVE DETAIL
              $podet = PoSupplierDetail::create( $poDetail );
          }
      }

    	//
    	return redirect( route('purchase_order_list') )->with('success', 'Purchase order created');
    }

    /**
     * List
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        //
        return view('admin/purchase_order/list');
    }

    /**
     * Get Data
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        // Get Supplier
        $records = PurchaseOrder::query()->where('status', '0');


        return Datatables::of($records)
                ->editColumn('shipment_term', function($record) {

                    return $record->shipment_term;
                })
                ->editColumn('po_number', function($record) {

                    $po_number = PurchaseOrder::select('po_number')->where( 'id', $record->id )->first();

                    return '<a href="'.route('view_purchase_order', $record->id).'"">
                        '.$po_number->po_number.'
                    </a>';
                })
                ->editColumn('supplier_id', function($record) {

                    $supplier = Supplier::select('supplier_name')->where( 'id', $record->supplier_id )->first();
                    return $supplier->supplier_name;
                })
                ->editColumn('supplier_contact_id', function($record) {

                    $contact = SupplierContact::select('contact_name')->where( 'id', $record->supplier_contact_id )->first();
                    return $contact->contact_name;
                })
                ->editColumn('payment_term', function($record) {

                    return $record->shipment_term;
                })->editColumn('cost_freight_amount', function($record) {

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
                ->editColumn('qs_rating', function($record) {

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

                        <a href="'.route('view_purchase_order', $record->id).'"">
                            <img class="view-action" src="'.asset("/admin/images/view.png").'">
                        </a>

                        &nbsp&nbsp&nbsp&nbsp&nbsp

                        <a href="'.route('delete_purchase_order', $record->id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                            <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                        </a>

                    ';
                })
                ->rawColumns(['po_number','pr_id','id', 'action'])

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
        // PurchaseOrder::destroy( $id );
        $podel['status'] = 1;
        PurchaseOrder::where('id', $id)->update( $podel );


        //
        return redirect( route('purchase_order_list') )->with('success', 'Purchase order deleted!');
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
        $data = PurchaseOrder::find( $id );
        $dataall = PurchaseOrder::all();
        $pr = PurchaseRequest::all();
        $rfq = Rfq::all();

        //
        return view('admin/purchase_order/view')->with( 'pr', $pr )->with( 'data', $data )->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq )->with( 'dataall', $dataall );
    }

    /**
     * Detail
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(Request $request, $id)
    {
        //
        $supplier = Supplier::all();
        $supplierContact = SupplierContact::all();
        $data = PoSupplierDetail::where( 'pos_id', $id )->first();
        $items = Items::all();
        $rfq = Rfq::all();

        //
        return view('admin/purchase_order/detail')->with( 'data', $data )->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq )->with( 'purchaseOrderId', $id )->with( 'items', $items );
    }

    /**
     * Save Detail
     *
     * @return \Illuminate\Http\Response
     */
    public function saveDetail(Request $request)
    {
        // Parameters
        $input = $request->all();
        $id = $request->purchase_order_id;
        $data['pos_id'] = $id;
        $data['pr_detail_id'] = $request->pr_detail_id;
        $data['sequence_number'] = $request->sequence_number;
        $data['product_id'] = $request->product_id;
        $data['qty_pos'] = $request->qty_pos;
        $data['um_pos'] = $request->um_pos;
        $data['balance_qty'] = $request->balance_qty;
        $data['curr'] = $request->curr;
        $data['unit_price'] = $request->unit_price;
        $data['have_external_reference'] = $request->have_external_reference;
        $data['target_date_original'] = $request->target_date_original;
        $data['target_date_new'] = $request->target_date_new;
        $data['last_arrival_date'] = $request->last_arrival_date;
        $data['status'] = $request->status;
        $data['created_by'] = Auth::user()->name;
        $data['modified_by'] = Auth::user()->name;

        //
        if( PoSupplierDetail::where( 'pos_id', $id )->exists() )
        {
            //
            PoSupplierDetail::where('pos_id', $id)->update( $data );
        }
        else
        {
            //
            PoSupplierDetail::create( $data );
        }


        //
        return redirect( route('purchase_order_list') )->with('success', 'Purchase order detail updated successfully!');
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
        $data['po_number'] = $request->po_number;
        $data['pr_id'] = $request->pr_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['supplier_contact_id'] = $request->supplier_contact_id;
        $data['shipment_term'] = $request->shipment_term;
        $data['payment_term'] = $request->payment_term;
        $data['import_via'] = $request->import_via;
        $data['cost_freight'] = $request->cost_freight;
        $data['cost_freight_amount'] = $request->cost_freight_amount;
        $data['vat'] = $request->vat;
        $data['qs_rating'] = $request->qs_rating;
        $data['remark'] = $request->remark;
        //$data['attached_file'] = $request->attached_file;
        $data['status'] = $request->status;
        $data['invoice_status'] = $request->invoice_status;
        $data['pos_supplier_rating'] = $request->pos_supplier_rating;
        $data['approved'] = ( isset( $input['approved'] ) ? 1 : 0 );
        // $data['approved_by'] = $request->approved_by;
        // $data['approved_date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->approved_date)));
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
        PurchaseOrder::where('id', $id)->update( $data );

        if( !empty( $request->items ) )
        {
            //ITEMS
            foreach ($request->items as $itemId => $get)
            {

                $poDetail['qty_pos'] = $get["qty"];
                $poDetail['um_pos'] = $get["um"];
                $poDetail['unit_price'] = $get["unit_cost"];
                $poDetail['modified_by'] = Auth::user()->name;

                //SAVE DETAIL
                $podet = PoSupplierDetail::where('pos_id', $id)->where('product_id', $itemId)->update( $poDetail );

            }
        }

        //
        return redirect( route('purchase_order_list') )->with('success', 'Purchase order updated!');
    }

        public function approve()
        {
            return view('admin/purchase_order/approve');
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
                PurchaseOrder::where('id', $id)->update( $data );

                //
                return redirect( route('view_purchase_order_approve',$id) )->with('success', 'Purchase Order aprroved!');
            }
            else
            {
                // Parameters
                $data['rejected'] = 1;
                $data['approved'] = 0;
                $data['reject_reason'] = $request->reason;
                $data['approved_by'] = Auth::user()->name;

                //
                PurchaseOrder::where('id', $request->id)->update( $data );

                //
                return redirect( route('view_purchase_order_approve',$request->id) )->with('success', 'Purchase Order rejected!');
            }

            //

        }

        public function getApproveData($dataid)
        {
            // Get Supplier
            $records = PurchaseOrder::query()->whereIn( 'id', explode( ',', $dataid ) );


            return Datatables::of($records)
                    ->editColumn('po_number', function($record) {

                        return $record->po_number;
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

                            <a href="'.route('purchase_order_approve_status_approve', array($record->id, 'approve')).'">
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
                    ->rawColumns(['id', 'action'])

                ->make(true);
        }

        public function viewApprove(Request $request, $id)
        {
            //
            $supplier = Supplier::all();
            $supplierContact = SupplierContact::all();
            $rfq = Rfq::all();
            $dataall = PurchaseOrder::all();
            $pr = PurchaseRequest::all();
            $data = PurchaseOrder::find( $id );

            //
            return view('admin/purchase_order/viewapprove')->with( 'pr', $pr )->with( 'data', $data )->with( 'suppliers', $supplier )->with( 'supplierContacts', $supplierContact )->with( 'rfq', $rfq )->with( 'dataall', $dataall );
        }

        public function getApproveData2(Request $request)
        {
            // Get Supplier
            $records = PurchaseOrder::query();


            return Datatables::of($records)
                    ->editColumn('po_number', function($record) {

                        return '<a href="'.route('view_purchase_order_approve', $record->id).'"">
                            #'.$record->po_number.'
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
                    ->rawColumns(['po_number','id', 'action'])

                ->make(true);
        }

}
