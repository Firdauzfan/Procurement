	@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">Create Quotation</h3>
			</div>
		</div>
	</div>
	<form action="{{ route('save_quotation') }}" method="post" enctype="multipart/form-data">
	<div class="tab-content padding40px shadowDiv">

			{!! csrf_field() !!}
			<div class="row" id="m_user_profile_tab_1">
					<div class="col-md-6">

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation Supplier Number</label>
							<div class="col-md-7">
								<input required="" name="qs_num" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation Supplier Date</label>
							<div class="col-md-7">
								<input required="" name="qs_date" class="form-control m-input" type="date">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Request For Quote</label>
							<div class="col-md-7">
								<select required="" onchange="rfqnumber(this.value)" name="rfq_id" class="form-control">
									@foreach( $rfq as $get )
										<option value="{{ $get->id }}">{{ $get->rfq_number }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Supplier</label>
							<div class="col-md-7">
								<input required="" id='suppname' class="form-control m-input" type="text">
								<input required="" id='suppid' name="supplier_id" class="form-control m-input" type="text" hidden>
								<!-- <select required="" name="supplier_id" class="form-control">
									@foreach( $suppliers as $get )
										<option value="{{ $get->id }}">{{ $get->supplier_name }}</option>
									@endforeach
								</select> -->
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Supplier Contact</label>
							<div class="col-md-7">
								<input required="" id='suppconname' class="form-control m-input" type="text">
								<input required="" id='suppconid' name="supplier_contact_id" class="form-control m-input" type="text" hidden>
								<!-- <select required="" name="supplier_contact_id" class="form-control">
									@foreach( $supplierContacts as $get )
										<option value="{{ $get->id }}">{{ $get->contact_name }}</option>
									@endforeach
								</select> -->
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Shipment Term</label>
							<div class="col-md-7">
								<input required="" name="shipment_term" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Payment Term</label>
							<div class="col-md-7">
								<input required="" name="payment_term" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Import Via</label>
							<div class="col-md-7">
								<select required="" name="import_via" class="form-control">
									<option value="0">Local</option>
									<option value="1">Air</option>
									<option value="2">Sea</option>
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Delivery Time</label>
							<div class="col-md-7">
								<input required="" name="delivertime" class="form-control m-input" type="number">
							</div>
						</div>

					</div>

					<div class="col-md-6">

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Cost Freight</label>
							<div class="col-md-7">
								<select required="" name="cost_freight" class="form-control">
									<option value="0">Paid</option>
									<option value="1">Not Paid</option>
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Cost Freight Amount</label>
							<div class="col-md-7">
								<input required="" name="cost_freight_amount" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation Supplier Rating</label>
							<div class="col-md-7">
								<input required="" name="qs_rating" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Remark</label>
							<div class="col-md-7">
								<input required="" name="remark" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Attached File</label>
							<div class="col-md-7">
								<input required="" name="attached_file" class="form-control m-input file-input" type="file">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Status</label>
							<div class="col-md-7">
								<input required="" name="status" class="form-control m-input" type="text">
							</div>
						</div>


						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Tax (%)</label>
							<div class="col-md-7">
								<input required="" name="tax" class="form-control m-input" type="number">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Discount (%)</label>
							<div class="col-md-7">
								<input required="" name="discount" class="form-control m-input" type="number">
							</div>
						</div>

					</div>
</div>
</div>
					<!-- RFQ Detail -->

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
															 <th>Total</th>
							                 <!-- <th>Action</th> -->
							              </tr>
							           </thead>

									</table>

									<!-- /Item Module -->

									<div class="m-portlet__foot m-portlet__foot--fit margin50px">
										<div class="form-group m-form__group row">
											<label for="example-text-input" class="col-md-3 col-form-label">Term & Condition</label>
											<div class="col-md-7">
												<textarea rows="4" cols="80" name="termcondition" placeholder="Term&Condition" class="form-control" required></textarea>
											</div>
										</div>
										<div class="m-form__actions">
											<div class="row">
												<div class="col-12">
													<button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Create</button>&nbsp;&nbsp;
													<button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
													<!--<a href="{{ route('create_item') }}" class="btn btn-secondary m-btn m-btn--air m-btn--custom"><i class="fa fa-plus"></i>&nbsp&nbspAdd Item</a>-->
												</div>
											</div>
										</div>
									</div>


								</div>

						</div>
	</form>
</div>
<link href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href='{{ asset("/css/jquery-ui.min.css") }}' />
<!-- <style>.dataTables_length{display: none;} .dataTables_filter{display: none;}</style> -->
<script type="text/javascript" src='{{ asset("/js/jquery-ui.min.js") }}'></script>
<script type="text/javascript" src='{{ asset("/js/jquery.dataTables.min.js") }}'></script>

<script type="text/javascript" src='{{ asset("/js/dataTables.bootstrap4.min.js") }}'></script>
<script type="text/javascript">
//
function getItemTable(productIds, rfqId)
{
	// console.log(productIds)
	// console.log(rfqId)
	$(function() {
       var table = $('#table').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{ URL::to('items/tablerfq') }}/"+productIds+"/"+rfqId,
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
                { data: 'total', name: 'total' },
                // { data: 'delete', name: 'delete' },

             ]
    });


 	});
}

//
function rfqnumber(value)
{
	// console.log(value)
	$.ajax(
	{
	  url: "{{ URL::to('items/rfqnumber/get') }}/"+value
	})
	.done(function(data)
	{
		var table = $('#table').DataTable();
		table.destroy();
		getItemTable( data.productIds, data.rfqId );
		document.getElementById("suppname").value = data.suppname;
		document.getElementById("suppid").value = data.rfqsuppid;
		document.getElementById("suppconname").value = data.consuppname;
		document.getElementById("suppconid").value = data.rfqconsuppid;

		// console.log(data.rfqsuppid);
		// console.log(data.suppname);
		// console.log(data.rfqconsuppid);
		// console.log(data.consuppname);
	});

}
//


 </script>
 <script>
function oninput(){
	var x = document.getElementById("quantityrfq").value;
  document.getElementById("total").innerHTML = x;
}
 </script>

@endsection
