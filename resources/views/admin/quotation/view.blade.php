	@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">Upate Quotation</h3>
			</div>
		</div>
	</div>
	<form action="{{ route('update_quotation') }}" method="post" enctype="multipart/form-data">
	<div class="tab-content padding40px shadowDiv">

			<input required="" name="id" value="{{ $data->id }}" class="form-control m-input" type="hidden">
			{!! csrf_field() !!}
			<div class="row" id="m_user_profile_tab_1">
					<div class="col-md-6">

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation Supplier Number</label>
							<div class="col-md-7">
								<select required="" name="qs_num" class="form-control" onchange="location = this.value;">
									@foreach( $dataall as $get )
										@if( $get->qs_num == $data->qs_num)
											<option value="{{ $data->qs_num }}" selected=""> {{ $data->qs_num }}</option>
										@else
											<option value="{{ $get->id }}"> {{ $get->qs_num }}</option>
										@endif
									@endforeach
								</select>
								<!-- <input required="" name="qs_num" value="{{ $data->qs_num }}" class="form-control m-input" type="text"> -->
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Request For Quote</label>
							<div class="col-md-7">
									@foreach( $rfq as $get )
										@if( $data->rfq_id == $get->id )
											<input required="" value="{{ $get->rfq_number }}" class="form-control" type="text" readonly>
											<input required="" name="rfq_id" value="{{ $get->id }}" class="form-control" type="text" hidden>
										@endif
									@endforeach
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation Supplier Date</label>
							<div class="col-md-7">
								<input required="" name="qs_date" value="{{ $data->qs_date }}" class="date form-control m-input" type="text" readonly>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Supplier</label>
							<div class="col-md-7">
									@foreach( $suppliers as $get )
										@if( $data->supplier_id == $get->id )
											<input required="" value="{{ $get->supplier_name }}" class="form-control" type="text" readonly>
										  <input required="" name="supplier_id" value="{{ $get->id }}" class="form-control" type="text" hidden>
										@endif
									@endforeach
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Supplier Contact</label>
							<div class="col-md-7">
									@foreach( $supplierContacts as $get )
										@if( $data->supplier_contact_id == $get->id )
											<input required="" value="{{ $get->contact_name }}" class="form-control" type="text" readonly>
											<input required="" name="supplier_contact_id" value="{{ $get->id }}" class="form-control" type="text" hidden>
										@endif
									@endforeach
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Shipment Term</label>
							<div class="col-md-7">
								<input required="" name="shipment_term" value="{{ $data->shipment_term }}" class="form-control m-input" type="text" readonly>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Payment Term</label>
							<div class="col-md-7">
								<input required="" name="payment_term" value="{{ $data->payment_term }}" class="form-control m-input" type="text" readonly>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Import Via</label>
							<div class="col-md-7">
									<?php
									if ($data->import_via == 0) {
										echo '<input required="" name="import_via" value="0" class="form-control m-input" type="text" hidden>';
										echo '<input required="" value="Local" class="form-control m-input" type="text" readonly>';
									}else if ($data->import_via == 1){
										echo '<input required="" name="import_via" value="1" class="form-control m-input" type="text" hidden>';
										echo '<input required="" value="Air" class="form-control m-input" type="text" readonly>';
									}else if ($data->import_via == 2){
										echo '<input required="" name="import_via" value="2" class="form-control m-input" type="text" hidden>';
										echo '<input required="" value="Sea" class="form-control m-input" type="text" readonly>';
									}
									 ?>

							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Delivery Time</label>
							<div class="col-md-7">
								<input required="" name="delivertime" value="{{ $data->delivertime }}" class="form-control m-input" type="number" readonly>
							</div>
						</div>
					</div>

					<div class="col-md-6">

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Cost Freight</label>
							<div class="col-md-7">
								<?php
								if ($data->cost_freight == 0) {
									echo '<input required="" name="cost_freight" value="0" class="form-control m-input" type="text" hidden>';
									echo '<input required="" value="Paid" class="form-control m-input" type="text" readonly>';
								}else if ($data->cost_freight == 1){
									echo '<input required="" name="cost_freight" value="1" class="form-control m-input" type="text" hidden>';
									echo '<input required="" value="Not Paid" class="form-control m-input" type="text" readonly>';
								}
								 ?>

							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Cost Freight Amount</label>
							<div class="col-md-7">
								<input required="" name="cost_freight_amount" value="{{ $data->cost_freight_amount }}" class="form-control m-input" type="text" readonly>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation Supplier Rating</label>
							<div class="col-md-7">
								<input required="" name="qs_rating" value="{{ $data->qs_rating }}" class="form-control m-input" type="text" readonly>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Remark</label>
							<div class="col-md-7">
								<input required="" name="remark" value="{{ $data->remark }}" class="form-control m-input" type="text" readonly>
							</div>
						</div>

						<!-- <div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Attached File</label>
							<div class="col-md-7">
								<input name="attached_file" value="{{ $data->attached_file }}" class="form-control m-input file-input" type="file">
							</div>
						</div> -->

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Status</label>
							<div class="col-md-7">
								<input required="" name="status" value="{{ $data->status }}" class="form-control m-input" type="text" readonly>
							</div>
						</div>
						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Tax (%)</label>
							<div class="col-md-7">
								<input required="" name="tax" value="{{ $data->tax }}" class="form-control m-input" type="number" readonly>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Discount (%)</label>
							<div class="col-md-7">
								<input required="" name="discount" value="{{ $data->discount }}" class="form-control m-input" type="number" readonly>
							</div>
						</div>

					</div>




			</div>
	</div>
			<div class="m-subheader ">
				<div class="d-flex align-items-center">
					<div class="mr-auto">
						<h3 class="m-subheader__title ">Quotation Detail</h3>
					</div>
				</div>
			</div>


			<div class="tab-content padding40px shadowDiv itemDiv">

					<!-- <span class="product-tab">Products</span> -->

					<div class="row" id="m_user_profile_tab_1">

						<!-- Item Module -->

						<table class="table table-bordered" id="table">
							<thead>
											<tr>
												 <th>MFR</th>
												 <th>Part Name</th>
												 <th>Part Number</th>
												 <th>Part Description</th>
												 <th>Quantity</th>
												 <th>UM</th>
												 <th>Price</th>
												 <!-- <th>Total</th> -->
											</tr>
									 </thead>

						</table>

					</div>


			<div class="m-portlet__foot m-portlet__foot--fit margin50px">
				<div class="form-group m-form__group row">
					<label for="example-text-input" class="col-md-3 col-form-label">Term & Condition</label>
					<div class="col-md-7">
						<textarea rows="4" cols="80" readonly name="termcondition" placeholder="Term&Condition" value="{{ $data->termcondition }}" class="form-control" required><?php echo $data->termcondition; ?></textarea>
					</div>
				</div>
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
	</form>
</div>

<?php
$dataid = $data->id;

 ?>

<link href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href='{{ asset("/css/jquery-ui.min.css") }}' />
<!-- <style>.dataTables_length{display: none;} .dataTables_filter{display: none;}</style> -->
<script type="text/javascript" src='{{ asset("/js/jquery-ui.min.js") }}'></script>
<script type="text/javascript" src='{{ asset("/js/jquery.dataTables.min.js") }}'></script>

<script type="text/javascript" src='{{ asset("/js/dataTables.bootstrap4.min.js") }}'></script>
<script type="text/javascript">
//
function getItemTable(productIds, qsId)
{
	console.log(productIds)
	console.log(qsId)
	$(function() {
       var table = $('#table').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{ URL::to('items/tableqs') }}/"+productIds+"/"+qsId,
       columns: [
                { data: 'mfr', name: 'mfr' },
                { data: 'part_name', name: 'part_name' },
                { data: 'part_num', name: 'part_num' },
                { data: 'part_desc', name: 'part_desc' },
								// { data: 'sequence_number', name: 'sequence_number' },
								// { data: 'type_product_id', name: 'type_product_id' },
                { data: 'qty', name: 'qty' },
                { data: 'um', name: 'um' },
								{ data: 'unit_cost', name: 'unit_cost' },
                // { data: 'total', name: 'total' },
                // { data: 'delete', name: 'delete' },

             ]
    });


 	});
}


//
function qsnumber(value)
{
	// console.log(value)
	$.ajax(
	{
	  url: "{{ URL::to('items/qsnumber/get') }}/"+value
	})
	.done(function(data)
	{
		var table = $('#table').DataTable();
		table.destroy();
		getItemTable( data.productIds, data.qsId );
	});

}

var dataid = "<?php echo $dataid ?>";
// console.log(dataid)
window.onload=qsnumber(dataid);


 </script>
@endsection
