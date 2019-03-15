@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
<div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title ">Update Purchase Request</h3>
    </div>
  </div>
</div>
<form action="{{ route('update_purchase_request') }}" method="post">
<div class="tab-content padding40px shadowDiv">

    {!! csrf_field() !!}
    <div class="row" id="m_user_profile_tab_1">
        <div class="col-md-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">PR Number</label>
            <div class="col-md-7">
              <select required="" name="pr_number" class="form-control" onchange="location = this.value;">
                @foreach( $dataall as $get )
                  @if( $get->pr_number == $data->pr_number)
                    <option value="{{ $data->pr_number }}" selected=""> {{ $data->pr_number }}</option>
                  @else
                    <option value="{{ $get->id }}"> {{ $get->pr_number }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Qs Number</label>
            <div class="col-md-7">
              @foreach( $qsdata as $qsdataa )

                @if( $qsdataa->id == $data->qs_id )
                  <input readonly required="" class="form-control" value="{{ $qsdataa->qs_num }}">
                @endif

              @endforeach
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Request From</label>
            <div class="col-md-7">
              <input required="" name="request_from" value="{{ $data->request_from }}" class="form-control m-input" type="text" readonly>
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Purpose</label>
            <div class="col-md-7">
              <input required="" name="purpose" value="{{ $data->purpose }}" class="form-control m-input" type="text" readonly>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Purchase Request Date</label>
            <div class="col-md-7">
              <input required="" name="pr_date" value="{{ $data->pr_date }}" class="form-control m-input" type="text" readonly>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Request Mode</label>
            <div class="col-md-7">
              <?php
              if ($data->request_mode == 0) {
                echo '<input required="" name="request_mode" value="0" hidden class="form-control m-input" type="text" readonly>';
                echo '<input required="" value="Routine" class="form-control m-input" type="text" readonly>';
              }else if ($data->request_mode == 1) {
                echo '<input required="" name="request_mode" value="1" hidden class="form-control m-input" type="text" readonly>';
                echo '<input required="" value="Not Routine" class="form-control m-input" type="text" readonly>';
              }

               ?>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Purpose Remark</label>
            <div class="col-md-7">
              <input required="" name="purpose_remark" value="{{ $data->purpose_remark }}" class="form-control m-input" type="text" readonly>
            </div>
          </div>
        </div>

        <input required="" type="hidden" value="{{ $data->id }}" name="id">

    </div>

</div>

<!-- RFQ Detail -->

<div class="tab-content padding40px shadowDiv">
  <div class="m-subheader ">
    <div class="d-flex align-items-center">
      <div class="mr-auto">
        <!--<h3 class="m-subheader__title ">Request For Quotation Detail</h3>-->
      </div>
    </div>
  </div>


  <div class="tab-content padding40px shadowDiv itemDiv">

      <span class="product-tab">Products</span>

      <div class="row" id="m_user_profile_tab_1">

        <!-- Item Module -->
        <?php if ($data->qs_id == '0'){
							echo '<a id="additem" class="btn btn-accent m-btn m-btn--air m-btn--custom" data-toggle="modal" data-target="#modalLoginForm">Add Item</a>&nbsp;&nbsp;';
						}
					?>
        <table class="table table-bordered" id="table">
          <thead>
                  <tr>
                     <th>MFR</th>
                     <th>Part Name</th>
                     <th>Part Number</th>
                     <th>Part Description</th>
                     <th>Quantity</th>
                     <th>UM</th>
                     <th>Action</th>
                  </tr>
               </thead>

        </table>

      </div>

  </div>

        <div class="m-portlet__foot m-portlet__foot--fit margin50px">
          <div class="m-form__actions">
            <div class="row">
              <div class="col-12">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Update</button>&nbsp;&nbsp;
                <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
              </div>
            </div>
          </div>
        </div>


    </div>

</div>

<!-- /RFQ Detail -->

</form>
</div>

<?php
$dataid = $data->id;

 ?>
 <form action="{{ route('save_additem_update') }}" method="post">
 <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
 	aria-hidden="true">
 	<div class="modal-dialog" role="document">
 		<div class="modal-content">
 			{!! csrf_field() !!}
 		<div class="form-group m-form__group row">
 		 <label for="example-text-input" class="col-md-3 col-form-label">Quantity</label>
 		 <div class="col-md-7">
 			 <input required type="text" name="qty_rfq" placeholder="Quantity" class="form-control">
 		 </div>
 	 </div>

 	 <div class="form-group m-form__group row">
 		<label for="example-text-input" class="col-md-3 col-form-label">UM</label>
 		<div class="col-md-7">
 			<input required type="text" name="um_rfq" placeholder="UM" class="form-control">
 		</div>
 	</div>
 			<div class="modal-header text-center">
 				<h4 class="modal-title w-100 font-weight-bold">Add Item</h4>
 				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
 					<span aria-hidden="true">&times;</span>
 				</button>
 			</div>
 			<input required="" type="hidden" value="{{ $data->id }}" name="id">

 			<table class="table table-bordered" id="table2">
 						 <thead>
 								<tr>
 									 <th>MFR</th>
 									 <th>Part Number</th>
 									 <th>Part Name</th>
 									 <th>Part Description</th>
 									 <th>Unit Cost</th>
 									 <th>Sell Price</th>
 									 <th>Action</th>
 								</tr>
 						 </thead>
 					</table>


 			<div class="modal-footer d-flex justify-content-center">
 				<button class="btn btn-default">Add</button>
 			</div>
 			<br>
 		</div>
 	</div>
 </div>
 </form>
<link href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href='{{ asset("/css/jquery-ui.min.css") }}' />
<!-- <style>.dataTables_length{display: none;} .dataTables_filter{display: none;}</style> -->
<script type="text/javascript" src='{{ asset("/js/jquery-ui.min.js") }}'></script>
<script type="text/javascript" src='{{ asset("/js/jquery.dataTables.min.js") }}'></script>

<script type="text/javascript" src='{{ asset("/js/dataTables.bootstrap4.min.js") }}'></script>
<script type="text/javascript">

$(function() {
               var table2 =$('#table2').DataTable({
               processing: true,
               serverSide: true,
               ajax: "{{ route('itemdata') }}",
               columns: [
                        { data: 'mfr', name: 'mfr' },
                        { data: 'part_num', name: 'part_num' },
                        { data: 'part_name', name: 'part_name' },
                        { data: 'part_desc', name: 'part_desc', searchable: 'false' },
                        { data: 'unit_cost', name: 'unit_cost', searchable: 'false' },
                        { data: 'sell_price', name: 'sell_price', searchable: 'false' },
                        { data: 'add', name: 'add', searchable: 'false' },

                     ]
            });
         });

 </script>
<script type="text/javascript">
//
function getItemTable(productIds, prId)
{
	console.log(productIds)
	console.log(prId)
	$(function() {
       var table = $('#table').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{ URL::to('items/tablepr') }}/"+productIds+"/"+prId,
       columns: [
                { data: 'mfr', name: 'mfr' },
                { data: 'part_name', name: 'part_name' },
                { data: 'part_num', name: 'part_num' },
                { data: 'part_desc', name: 'part_desc' },
								// { data: 'sequence_number', name: 'sequence_number' },
								// { data: 'type_product_id', name: 'type_product_id' },
                { data: 'qty', name: 'qty' },
                { data: 'um', name: 'um' },
								// { data: 'unit_cost', name: 'unit_cost' },
                // { data: 'total', name: 'total' },
                { data: 'delete', name: 'delete' },

             ]
    });


 	});
}


//
function prnumber(value)
{
	// console.log(value)
	$.ajax(
	{
	  url: "{{ URL::to('items/prnumber/get') }}/"+value
	})
	.done(function(data)
	{
		var table = $('#table').DataTable();
		table.destroy();
		getItemTable( data.productIds, data.prId );

	});

}

var dataid = "<?php echo $dataid ?>";
// console.log(dataid)
window.onload=prnumber(dataid);

function deleteItemTemp( uIds )
{
	var table = $('#table').DataTable();
	var inqId = $('.inquiry-customer').val();
	table.destroy();
	getItemTable(uIds, inqId);
}
 </script>
@endsection
