<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Items;
use App\Rfi;
use App\Rfq;
use App\Supplier;
use App\SupplierContact;
use App\RfqDetail;
use App\RfqTerm;
use App\RfiDetail;
use App\Quotation;
use App\QuotationDetail;
use App\PurchaseRequest;
use App\PRDetail;
use App\PurchaseOrder;
use App\PoSupplierDetail;
use App\PrTerm;
use Auth;
use Datatables;

class ItemsController extends Controller
{
    public $rfiIdGlobal = '';
    public $gPIds = '';
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
        return view('admin/items/create');
    }

    /**
     * Get items by the customer
     *
     * @return \Illuminate\Http\Response
     */
     public function getItemsByPo($poId)
     {
         //
         $allIds = [];
         $response = [];
         $pod = PurchaseOrder::find( $poId )->details;

         //
         foreach ($pod as $get)
         {
             $allIds[] = $get->product_id;
         }

         //
         $allIdsString = implode(',', $allIds);
         $response['productIds'] = $allIdsString;
         $response['poId'] = $poId;

         return $response;
     }

     public function getItemsByPr($prId)
     {
         //
         $allIds = [];
         $response = [];
         $prd = PurchaseRequest::find( $prId )->details;

         //
         foreach ($prd as $get)
         {
             $allIds[] = $get->product_id;
         }

         //
         $allIdsString = implode(',', $allIds);
         $response['productIds'] = $allIdsString;
         $response['prId'] = $prId;

         return $response;
     }

     public function getItemsByQs3()
     {
         $allIds = [];
         $allIdsTerm = [];
         $response = [];
         $user= Auth::user()->name;
         $qsterm = PrTerm::select()->where( 'created_by', $user )->get();
         // $rfqterm = RfqTerm::find( $user );

         //
         foreach ($qsterm as $get)
         {
             $allIds[] = $get->product_id;
             // $allIdsTerm[] = $get->id;
         }

         $allIdsString = implode(',', $allIds);
         // $allIdsTermString = implode(',', $allIdsTerm);
         $response['productIds'] = $allIdsString;
         $response['id'] = $user;
         return $response;
     }

     public function getItemsByQs2($qsId)
     {
         //
         $allIds = [];
         $response = [];
         $qsd = Quotation::find( $qsId )->details;

         //
         foreach ($qsd as $get)
         {
             $allIds[] = $get->product_id;
         }

         //
         $allIdsString = implode(',', $allIds);
         $response['productIds'] = $allIdsString;
         $response['qsId'] = $qsId;

         return $response;
     }

     public function getItemsByQs($qsId)
     {
         //
         $allIds = [];
         $response = [];
         $qsd = Quotation::find( $qsId )->details;

         //
         foreach ($qsd as $get)
         {
             $allIds[] = $get->product_id;
         }

         //
         $allIdsString = implode(',', $allIds);
         $response['productIds'] = $allIdsString;
         $response['qsId'] = $qsId;

         return $response;
     }

     public function getItemsByRfq($rfqId)
     {
         //
         $allIds = [];
         $response = [];
         $rfqd = Rfq::find( $rfqId )->details;
         $rfqsuppid = Rfq::select('supplier_id')->where( 'id', $rfqId )->first()->supplier_id;
         $suppliername = Supplier::select('supplier_name')->where( 'id', $rfqsuppid )->first()->supplier_name;

         $rfqconsuppid = Rfq::select('supplier_contact_id')->where( 'id', $rfqId )->first()->supplier_contact_id;
         $consuppliername = SupplierContact::select('contact_name')->where( 'id', $rfqconsuppid )->first()->contact_name;

         //
         foreach ($rfqd as $get)
         {
             $allIds[] = $get->product_id;
         }

         //
         $allIdsString = implode(',', $allIds);
         $response['productIds'] = $allIdsString;
         $response['rfqId'] = $rfqId;
         $response['rfqsuppid'] = $rfqsuppid;
         $response['suppname'] = $suppliername;
         $response['rfqconsuppid'] = $rfqconsuppid;
         $response['consuppname'] = $consuppliername;
         return $response;
     }

    public function getItemsByCustomer($rfiId)
    {
        //
        $allIds = [];
        $response = [];
        $rfid = Rfi::find( $rfiId )->details;

        //
        foreach ($rfid as $get)
        {
            $allIds[] = $get->product_id;
        }

        //
        $allIdsString = implode(',', $allIds);
        $response['productIds'] = $allIdsString;
        $response['rfiId'] = $rfiId;
        return $response;
    }

    public function getItemsByCustomer2()
    {
        //
        $allIds = [];
        $allIdsTerm = [];
        $response = [];
        $user= Auth::user()->name;
        $rfqterm = RfqTerm::select()->where( 'created_by', $user )->get();
        // $rfqterm = RfqTerm::find( $user );

        //
        foreach ($rfqterm as $get)
        {
            $allIds[] = $get->product_id;
            // $allIdsTerm[] = $get->id;
        }

        $allIdsString = implode(',', $allIds);
        // $allIdsTermString = implode(',', $allIdsTerm);
        $response['productIds'] = $allIdsString;
        $response['id'] = $user;
        return $response;
    }

    public function getItemsByCustomer3($id)
    {
        //
        $allIds = [];
        $allIdsTerm = [];
        $response = [];
        // $user= Auth::user()->name;
        // $rfqterm = RfqDetail::select()->where( 'created_by', $user )->get();
        $rfqid = Rfq::find( $id )->details;

        //
        foreach ($rfqid as $get)
        {
            $allIds[] = $get->product_id;
            // $allIdsTerm[] = $get->id;
        }

        $allIdsString = implode(',', $allIds);
        // $allIdsTermString = implode(',', $allIdsTerm);
        $response['productIds'] = $allIdsString;
        $response['id'] = $id;
        return $response;
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
        $data['mfr'] = $request->mfr;
        $data['category_part_num'] = $request->category_part_num;
        $data['part_num'] = $request->part_num;
        $data['part_name'] = $request->part_name;
        $data['part_desc'] = $request->part_desc;
        $data['default_um'] = $request->default_um;
        $data['default_curr'] = $request->default_curr;
        $data['unit_cost'] = $request->unit_cost;
        $data['sell_price'] = $request->sell_price;
        $data['break_down_price'] = $request->break_down_price;
        $data['item_price'] = $request->item_price;
        $data['price_date'] = $request->price_date;
        $data['lead_time'] = $request->lead_time;
        $data['price_valid_until'] = $request->price_valid_until;
        $data['item_need_qc'] = $request->item_need_qc;
        $data['status'] = $request->status;
    	$data['created_by'] = Auth::user()->name;
    	$data['modified_by'] = Auth::user()->name;

        //
    	$items = Items::create( $data );


    	//
    	return redirect( route('items_list') )->with('success', 'Item created');
    }

    /**
     * List
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        //
        return view('admin/items/list');
    }

    /**
     * Get Data
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        // Get Supplier
        $records = Items::query();

        return Datatables::of($records)
                ->editColumn('mfr', function($record) {

                    return $record->mfr;
                })
                ->editColumn('part_num', function($record) {

                    return $record->part_num;
                })
                ->editColumn('part_name', function($record) {

                    return $record->part_name;
                })
                ->editColumn('part_desc', function($record) {

                    return $record->part_desc;
                })
                ->editColumn('unit_cost', function($record) {

                    return $record->unit_cost;
                })
                ->editColumn('sell_price', function($record) {

                    return $record->sell_price;
                })
                ->editColumn('action', function($record) {

                    return '

                        &nbsp&nbsp

                        <a href="'.route('view_item', $record->id).'"">
                            <img class="view-action" src="'.asset("/admin/images/view.png").'">
                        </a>

                        &nbsp&nbsp&nbsp&nbsp&nbsp

                        <a href="'.route('delete_item', $record->id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                            <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                        </a>

                    ';
                })


                ->rawColumns(['id', 'action'])

            ->make(true);
    }

    /**
     * Item Table
     *
     * @return \Illuminate\Http\Response
     */
     public function itemTableRfq( $productIds, $rfqId )
     {

         // Get Supplier
         $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

         $this->rfqIdGlobal = $rfqId;
         $this->gPIds = $productIds;

         return Datatables::of($records, $rfqId)
                 ->editColumn('mfr', function($record) {

                     return $record->mfr;
                 })
                 ->editColumn('part_num', function($record) {

                     return $record->part_num;
                 })
                 ->editColumn('part_name', function($record) {

                     return $record->part_name;
                 })
                 ->editColumn('part_desc', function($record) {

                     return $record->part_desc;
                 })
                 ->editColumn('qty', function($record) {

                     $qty = RfqDetail::select('qty_rfq')->where( 'rfq_id', $this->rfqIdGlobal )->where( 'product_id', $record->id )->first()->qty_rfq;

                     return "<input id='quantityrfq' oninput='oninput()' class='item-um' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                     // return $qty;
                 })
                 ->editColumn('um', function($record) {

                     $um = RfqDetail::select('um_rfq')->where( 'rfq_id', $this->rfqIdGlobal )->where( 'product_id', $record->id )->first()->um_rfq;

                     return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]' readonly>";
                 })

                 ->editColumn('unit_cost', function($record) {

                     $unit_cost = $record->unit_cost;
                     return "<input id='price' class='item-um' type='text' value='$unit_cost' name='items[".$record->id."][unit_cost]'>";
                     // return $itemprice;
                 })

                 // ->editColumn('total', function($record) {
                 //
                 //     $itemprice = $record->item_price;
                 //     $qty = RfqDetail::select('qty_rfq')->where( 'rfq_id', $this->rfqIdGlobal )->where( 'product_id', $record->id )->first()->qty_rfq;
                 //     $total = $itemprice*$qty;
                 //     return '<span id="total"></span>';
                 // })

                 ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete','unit_cost','total'])

             ->make(true);
     }

     /**
      * Item Table
      *
      * @return \Illuminate\Http\Response
      */

     public function itemTableQs( $productIds, $qsId )
     {

         $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

         $this->qsIdGlobal = $qsId;
         $this->gPIds = $productIds;

         return Datatables::of($records, $qsId)
                 ->editColumn('mfr', function($record) {

                     return $record->mfr;
                 })
                 ->editColumn('part_num', function($record) {

                     return $record->part_num;
                 })
                 ->editColumn('part_name', function($record) {

                     return $record->part_name;
                 })
                 ->editColumn('part_desc', function($record) {

                     return $record->part_desc;
                 })
                 ->editColumn('qty', function($record) {

                     $qty = QuotationDetail::select('qty_qs')->where( 'qs_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->qty_qs;

                     return "<input class='item-um' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                     // return $qty;
                 })
                 ->editColumn('um', function($record) {

                     $um = QuotationDetail::select('um_qs')->where( 'qs_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->um_qs;

                     return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]' readonly>";
                 })

                 ->editColumn('unit_cost', function($record) {

                     $unit_cost = $record->unit_cost;
                     return "<input class='item-um' type='text' value='$unit_cost' name='items[".$record->id."][unit_cost]'>";
                     // return $itemprice;
                 })

                 // ->editColumn('total', function($record) {
                 //
                 //     $itemprice = $record->item_price;
                 //     $qty = QuotationDetail::select('qty_qs')->where( 'qs_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->qty_qs;
                 //     $total = $itemprice*$qty;
                 //     return $total;
                 // })

                 ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete','unit_cost','total'])

             ->make(true);
     }

     public function itemTableQs2( $productIds, $qsId )
     {

         $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

         $this->qsIdGlobal = $qsId;
         $this->gPIds = $productIds;

         return Datatables::of($records, $qsId)
                 ->editColumn('mfr', function($record) {

                     return $record->mfr;
                 })
                 ->editColumn('part_num', function($record) {

                     return $record->part_num;
                 })
                 ->editColumn('part_name', function($record) {

                     return $record->part_name;
                 })
                 ->editColumn('part_desc', function($record) {

                     return $record->part_desc;
                 })
                 ->editColumn('qty', function($record) {

                     $qty = QuotationDetail::select('qty_qs')->where( 'qs_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->qty_qs;

                     return "<input class='item-um' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                     // return $qty;
                 })
                 ->editColumn('um', function($record) {

                     $um = QuotationDetail::select('um_qs')->where( 'qs_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->um_qs;

                     return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]' readonly>";
                 })

                 ->editColumn('delete', function($record) {
                     $eIds = explode( ',', $this->gPIds );
                     $arr = array_merge(array_diff($eIds, array($record->id)));
                     $iIds = implode(',', $arr);
                     if( $iIds == null )
                     {
                         $iIds = 0;
                     }

                     return '

                         <a class="cursor" OnClick="deleteItemTemp('.$iIds.')">
                             <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                         </a>

                     ';

                 })

                 ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete','unit_cost'])

             ->make(true);
     }

     public function itemTablePr( $productIds, $prId )
     {

         $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

         $this->qsIdGlobal = $prId;
         $this->gPIds = $productIds;

         return Datatables::of($records, $prId)
                 ->editColumn('mfr', function($record) {

                     return $record->mfr;
                 })
                 ->editColumn('part_num', function($record) {

                     return $record->part_num;
                 })
                 ->editColumn('part_name', function($record) {

                     return $record->part_name;
                 })
                 ->editColumn('part_desc', function($record) {

                     return $record->part_desc;
                 })
                 ->editColumn('qty', function($record) {

                     $qty = PRDetail::select('qty_pr')->where( 'pr_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->qty_pr;

                     return "<input class='item-um' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                     // return $qty;
                 })
                 ->editColumn('um', function($record) {

                     $um = PRDetail::select('um_pr')->where( 'pr_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->um_pr;

                     return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]' readonly>";
                 })

                 ->editColumn('delete', function($record) {

                     $qsid= PurchaseRequest::select('qs_id')->where( 'id', $this->qsIdGlobal )->first()->qs_id;
                     if ($qsid == '0') {
                       $id = PrDetail::select('id')->where( 'pr_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first();

                       return '
                           &nbsp&nbsp&nbsp&nbsp&nbsp
                           <a class="cursor" href="'.route('itemdatadeletetable2', $id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                               <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                           </a>

                       ';
                     }else{
                       return ' ';
                     }

                     // $id = RfiDetail::select('id')->where( 'rfi_id', $this->rfiIdGlobal )->where( 'product_id', $record->id )->first()->id;
                     //
                     // return '
                     //     &nbsp&nbsp&nbsp&nbsp&nbsp
                     //     <a class="cursor" href="'.route('itemdatadeletetable', $id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                     //         <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                     //     </a>
                     //
                     // ';
                 })

                 ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete'])

             ->make(true);
     }

     public function itemTablePo( $productIds, $prId )
     {

         $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

         $this->qsIdGlobal = $prId;
         $this->gPIds = $productIds;

         return Datatables::of($records, $prId)
                 ->editColumn('mfr', function($record) {

                     return $record->mfr;
                 })
                 ->editColumn('part_num', function($record) {

                     return $record->part_num;
                 })
                 ->editColumn('part_name', function($record) {

                     return $record->part_name;
                 })
                 ->editColumn('part_desc', function($record) {

                     return $record->part_desc;
                 })
                 ->editColumn('qty', function($record) {

                     $qty = PRDetail::select('qty_pr')->where( 'pr_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->qty_pr;

                     return "<input class='item-um' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                     // return $qty;
                 })
                 ->editColumn('um', function($record) {

                     $um = PRDetail::select('um_pr')->where( 'pr_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->um_pr;

                     return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]' readonly>";
                 })

                 ->editColumn('unit_cost', function($record) {

                     $unit_cost = $record->unit_cost;
                     return "<input id='price' class='item-um' type='text' value='$unit_cost' name='items[".$record->id."][unit_cost]'>";
                     // return $itemprice;
                 })

                 ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete','unit_cost'])

             ->make(true);
     }

     public function itemTablePo2( $productIds, $poId )
     {

         $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

         $this->poIdGlobal = $poId;
         $this->gPIds = $productIds;

         return Datatables::of($records, $poId)
                 ->editColumn('mfr', function($record) {

                     return $record->mfr;
                 })
                 ->editColumn('part_num', function($record) {

                     return $record->part_num;
                 })
                 ->editColumn('part_name', function($record) {

                     return $record->part_name;
                 })
                 ->editColumn('part_desc', function($record) {

                     return $record->part_desc;
                 })
                 ->editColumn('qty', function($record) {

                     $qty = PoSupplierDetail::select('qty_pos')->where( 'pos_id', $this->poIdGlobal )->where( 'product_id', $record->id )->first()->qty_pos;

                     return "<input class='item-um' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                     // return $qty;
                 })
                 ->editColumn('um', function($record) {

                     $um = PoSupplierDetail::select('um_pos')->where( 'pos_id', $this->poIdGlobal )->where( 'product_id', $record->id )->first()->um_pos;

                     return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]' readonly>";
                 })

                 ->editColumn('unit_cost', function($record) {

                     $unit_cost = $record->unit_cost;
                     return "<input class='item-um' type='text' value='$unit_cost' name='items[".$record->id."][unit_cost]'>";
                     // return $itemprice;
                 })

                 // ->editColumn('total', function($record) {
                 //
                 //     $itemprice = $record->item_price;
                 //     $qty = QuotationDetail::select('qty_qs')->where( 'qs_id', $this->qsIdGlobal )->where( 'product_id', $record->id )->first()->qty_qs;
                 //     $total = $itemprice*$qty;
                 //     return $total;
                 // })

                 ->rawColumns(['type_product_id','sequence_number','id','qty','um','unit_cost'])

             ->make(true);
     }

    public function itemTable( $productIds, $rfiId )
    {

        // Get Supplier
        $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

        $this->rfiIdGlobal = $rfiId;
        $this->gPIds = $productIds;

        return Datatables::of($records, $rfiId)
                ->editColumn('mfr', function($record) {

                    return $record->mfr;
                })
                ->editColumn('part_num', function($record) {

                    return $record->part_num;
                })
                ->editColumn('part_name', function($record) {

                    return $record->part_name;
                })
                ->editColumn('part_desc', function($record) {

                    return $record->part_desc;
                })
                ->editColumn('qty', function($record) {

                    $qty = RfiDetail::select('qty_rfi')->where( 'rfi_id', $this->rfiIdGlobal )->where( 'product_id', $record->id )->first()->qty_rfi;

                    return "<input class='item-quantity' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                })
                ->editColumn('um', function($record) {

                    $um = RfiDetail::select('um_rfi')->where( 'rfi_id', $this->rfiIdGlobal )->where( 'product_id', $record->id )->first()->um_rfi;
                    return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]'>";
                })

                // ->editColumn('sequence_number', function($record) {
                //
                //     $sequence_number = RfiDetail::select('sequence_number')->where( 'rfi_id', $this->rfiIdGlobal )->where( 'product_id', $record->id )->first()->sequence_number;
                //     return "<input readonly class='item-um' type='text' value='$sequence_number' name='items[".$record->id."][sequence_number]'>";
                // })
                //
                // ->editColumn('type_product_id', function($record) {
                //
                //     $type_product_id = RfiDetail::select('type_product_id')->where( 'rfi_id', $this->rfiIdGlobal )->where( 'product_id', $record->id )->first()->type_product_id;
                //     return "<input readonly class='item-um' type='text' value='$type_product_id' name='items[".$record->id."][type_product_id]'>";
                // })

                ->editColumn('delete', function($record) {
                    $eIds = explode( ',', $this->gPIds );
                    $arr = array_merge(array_diff($eIds, array($record->id)));
                    $iIds = implode(',', $arr);
                    if( $iIds == null )
                    {
                        $iIds = 0;
                    }

                    return '

                        <a class="cursor" OnClick="deleteItemTemp('.$iIds.')">
                            <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                        </a>

                    ';

                    // $id = RfiDetail::select('id')->where( 'rfi_id', $this->rfiIdGlobal )->where( 'product_id', $record->id )->first()->id;
                    //
                    // return '
                    //     &nbsp&nbsp&nbsp&nbsp&nbsp
                    //     <a class="cursor" href="'.route('itemdatadeletetable', $id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                    //         <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                    //     </a>
                    //
                    // ';
                })



                ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete'])

            ->make(true);
    }

    /**
     * Item Table
     *
     * @return \Illuminate\Http\Response
     */

    public function itemTable2( $productIds, $id )
    {
        // $productIds = '5';
        // $id = '2';

        // Get Supplier
        $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

        $this->rfqtermIdGlobal = $id;
        $this->gPIds = $productIds;

        return Datatables::of($records, $id)
                ->editColumn('mfr', function($record) {

                    return $record->mfr;
                })
                ->editColumn('part_num', function($record) {

                    return $record->part_num;
                })
                ->editColumn('part_name', function($record) {

                    return $record->part_name;
                })
                ->editColumn('part_desc', function($record) {

                    return $record->part_desc;
                })
                ->editColumn('qty', function($record) {

                    $qty = RfqTerm::select('qty_rfi')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->qty_rfi;

                    return "<input class='item-quantity' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                })
                ->editColumn('um', function($record) {

                    $um = RfqTerm::select('um_rfi')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->um_rfi;
                    return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]'>";
                })

                // ->editColumn('sequence_number', function($record) {
                //
                //     $sequence_number = RfqTerm::select('sequence_number')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->sequence_number;
                //     return "<input readonly class='item-um' type='text' value='$sequence_number' name='items[".$record->id."][sequence_number]'>";
                // })
                //
                // ->editColumn('type_product_id', function($record) {
                //
                //     $type_product_id = RfqTerm::select('type_product_id')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->type_product_id;
                //     return "<input readonly class='item-um' type='text' value='$type_product_id' name='items[".$record->id."][type_product_id]'>";
                // })

                ->editColumn('delete', function($record) {
                    // $eIds = explode( ',', $this->gPIds );
                    // $arr = array_merge(array_diff($eIds, array($record->id)));
                    // $iIds = implode(',', $arr);
                    // if( $iIds == null )
                    // {
                    //     $iIds = 0;
                    // }
                    //
                    // return '
                    //
                    //     <a class="cursor" OnClick="deleteItemTemp('.$iIds.')">
                    //         <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                    //     </a>
                    //
                    // ';

                    $id = RfqTerm::select('id')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->id;

                    return '
                        &nbsp&nbsp&nbsp&nbsp&nbsp
                        <a class="cursor" href="'.route('itemdatadeletetable', $id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                            <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                        </a>

                    ';
                })



                ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete'])

            ->make(true);
    }

    public function itemTableQs3( $productIds, $id )
    {
        // $productIds = '5';
        // $id = '2';

        // Get Supplier
        $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

        $this->rfqtermIdGlobal = $id;
        $this->gPIds = $productIds;

        return Datatables::of($records, $id)
                ->editColumn('mfr', function($record) {

                    return $record->mfr;
                })
                ->editColumn('part_num', function($record) {

                    return $record->part_num;
                })
                ->editColumn('part_name', function($record) {

                    return $record->part_name;
                })
                ->editColumn('part_desc', function($record) {

                    return $record->part_desc;
                })
                ->editColumn('qty', function($record) {

                    $qty = PrTerm::select('qty_qs')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->qty_qs;

                    return "<input class='item-quantity' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                })
                ->editColumn('um', function($record) {

                    $um = PrTerm::select('um_qs')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->um_qs;
                    return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]'>";
                })

                // ->editColumn('sequence_number', function($record) {
                //
                //     $sequence_number = RfqTerm::select('sequence_number')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->sequence_number;
                //     return "<input readonly class='item-um' type='text' value='$sequence_number' name='items[".$record->id."][sequence_number]'>";
                // })
                //
                // ->editColumn('type_product_id', function($record) {
                //
                //     $type_product_id = RfqTerm::select('type_product_id')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->type_product_id;
                //     return "<input readonly class='item-um' type='text' value='$type_product_id' name='items[".$record->id."][type_product_id]'>";
                // })

                ->editColumn('delete', function($record) {
                    // $eIds = explode( ',', $this->gPIds );
                    // $arr = array_merge(array_diff($eIds, array($record->id)));
                    // $iIds = implode(',', $arr);
                    // if( $iIds == null )
                    // {
                    //     $iIds = 0;
                    // }
                    //
                    // return '
                    //
                    //     <a class="cursor" OnClick="deleteItemTemp('.$iIds.')">
                    //         <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                    //     </a>
                    //
                    // ';

                    $id = PrTerm::select('id')->where( 'created_by', $this->rfqtermIdGlobal )->where( 'product_id', $record->id )->first()->id;

                    return '
                        &nbsp&nbsp&nbsp&nbsp&nbsp
                        <a class="cursor" href="'.route('itemdatadeletetable', $id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                            <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                        </a>

                    ';
                })



                ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete'])

            ->make(true);
    }
    /**
     * Item Table
     *
     * @return \Illuminate\Http\Response
     */

    public function itemTable3( $productIds, $id )
    {

        // Get Supplier
        $records = Items::query()->whereIn( 'id', explode( ',', $productIds ) );

        $this->rfqlistIdGlobal = $id;
        $this->gPIds = $productIds;

        return Datatables::of($records, $id)
                ->editColumn('mfr', function($record) {

                    return $record->mfr;
                })
                ->editColumn('part_num', function($record) {

                    return $record->part_num;
                })
                ->editColumn('part_name', function($record) {

                    return $record->part_name;
                })
                ->editColumn('part_desc', function($record) {

                    return $record->part_desc;
                })
                ->editColumn('qty', function($record) {

                    $qty = RfqDetail::select('qty_rfq')->where( 'rfq_id', $this->rfqlistIdGlobal )->where( 'product_id', $record->id )->first()->qty_rfq;

                    return "<input class='item-quantity' type='text' value='$qty' name='items[".$record->id."][qty]'>";
                })
                ->editColumn('um', function($record) {

                    $um = RfqDetail::select('um_rfq')->where( 'rfq_id', $this->rfqlistIdGlobal )->where( 'product_id', $record->id )->first()->um_rfq;
                    return "<input class='item-um' type='text' value='$um' name='items[".$record->id."][um]'>";
                })

                // ->editColumn('sequence_number', function($record) {
                //
                //     $sequence_number = RfqDetail::select('sequence_number')->where( 'rfq_id', $this->rfqlistIdGlobal )->where( 'product_id', $record->id )->first()->sequence_number;
                //     return "<input readonly class='item-um' type='text' value='$sequence_number' name='items[".$record->id."][sequence_number]'>";
                // })
                //
                // ->editColumn('type_product_id', function($record) {
                //
                //     $type_product_id = RfqDetail::select('type_product_id')->where( 'rfq_id', $this->rfqlistIdGlobal )->where( 'product_id', $record->id )->first()->type_product_id;
                //     return "<input readonly class='item-um' type='text' value='$type_product_id' name='items[".$record->id."][type_product_id]'>";
                // })

                ->editColumn('delete', function($record) {
                    // $eIds = explode( ',', $this->gPIds );
                    // $arr = array_merge(array_diff($eIds, array($record->id)));
                    // $iIds = implode(',', $arr);
                    // if( $iIds == null )
                    // {
                    //     $iIds = 0;
                    // }
                    //
                    // return '
                    //
                    //     <a class="cursor" OnClick="deleteItemTemp('.$iIds.')">
                    //         <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                    //     </a>
                    //
                    // ';
                    $rfqinquiry= Rfq::select('inquiry_customer')->where( 'id', $this->rfqlistIdGlobal )->first()->inquiry_customer;
                    if ($rfqinquiry == '0') {
                      $id = RfqDetail::select('id')->where( 'rfq_id', $this->rfqlistIdGlobal )->where( 'product_id', $record->id )->first();

                      return '
                          &nbsp&nbsp&nbsp&nbsp&nbsp
                          <a class="cursor" href="'.route('itemdatadeletetable2', $id).'" OnClick="return confirm(\' Are you sure to delete it \');"">
                              <img class="delete-action" src="'.asset("/admin/images/delete.png").'">
                          </a>

                      ';
                    }else{
                      return ' ';
                    }


                })



                ->rawColumns(['type_product_id','sequence_number','id','qty','um','delete'])

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
        Items::destroy( $id );

        //
        return redirect( route('items_list') )->with('success', 'Item deleted!');
    }

    /**
     * View
     *
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        //
        $data = Items::find( $id );

        //
        return view('admin/items/view')->with( 'data', $data );
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
        $data['mfr'] = $request->mfr;
        $data['category_part_num'] = $request->category_part_num;
        $data['part_num'] = $request->part_num;
        $data['part_name'] = $request->part_name;
        $data['part_desc'] = $request->part_desc;
        $data['default_um'] = $request->default_um;
        $data['default_curr'] = $request->default_curr;
        $data['unit_cost'] = $request->unit_cost;
        $data['sell_price'] = $request->sell_price;
        $data['break_down_price'] = $request->break_down_price;
        $data['item_price'] = $request->item_price;
        $data['price_date'] = $request->price_date;
        $data['lead_time'] = $request->lead_time;
        $data['price_valid_until'] = $request->price_valid_until;
        $data['item_need_qc'] = $request->item_need_qc;
        $data['status'] = $request->status;
        $data['created_by'] = Auth::user()->name;
        $data['modified_by'] = Auth::user()->name;

        //
        Items::where('id', $id)->update( $data );

        //
        return redirect( route('items_list') )->with('success', 'Item updated!');
    }

}
