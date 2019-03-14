@extends('layouts.admin')

@section('content')
<style>
.filter
{
	display: none;
}
</style>
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">Purchase Request</h3>
			</div>
		</div>
	</div>
	<form action="{{ route('save_purchase_request') }}" method="post">
	<div class="tab-content padding40px shadowDiv">

			{!! csrf_field() !!}
			<div class="row" id="m_user_profile_tab_1">
					<div class="col-md-6">

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Purchase Request Number</label>
							<div class="col-md-7">
                <input type="text" placeholder="Purchase Request Number" class="form-control" name="pr_number" required>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Request From</label>
							<div class="col-md-7">
                <input type="text" placeholder="Request From" class="form-control" name="request_from" required>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Purpose</label>
							<div class="col-md-7">
                <input type="text" placeholder="Purpose" class="form-control" name="purpose" required>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Purpose Remark</label>
							<div class="col-md-7">
								<input type="text" placeholder="Purpose Remark" name="purpose_remark" class="form-control" id="" required>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Request Mode</label>
							<div class="col-md-7">
								<select name="request_mode" class="filter-by form-control">
									<option value="0">Routine</option>
									<option value="1">Non Routine</option>
								</select>
							</div>
						</div>


						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Purchase Request Date</label>
							<div class="col-md-7">
								<input type="date" name="pr_date" class="form-control" required>
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
		                 <th>Action</th>
		              </tr>
		           </thead>

				</table>

				<!-- /Item Module -->

				<div class="m-portlet__foot m-portlet__foot--fit margin50px">
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

	<!-- /RFQ Detail -->

	</form>
</div>

<link href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href='{{ asset("/css/jquery-ui.min.css") }}' />
<style>.dataTables_length{display: none;} .dataTables_filter{display: none;}</style>
<script type="text/javascript" src='{{ asset("/js/jquery-ui.min.js") }}'></script>
<script type="text/javascript" src='{{ asset("/js/jquery.dataTables.min.js") }}'></script>

<script type="text/javascript" src='{{ asset("/js/dataTables.bootstrap4.min.js") }}'></script>

<script type="text/javascript">

//
function getItemTable(productIds, rfiId)
{
	$(function() {
       var table = $('#table').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{ URL::to('items/table') }}/"+productIds+"/"+rfiId,
       columns: [
                { data: 'mfr', name: 'mfr' },
                { data: 'part_name', name: 'part_name' },
                { data: 'part_num', name: 'part_num' },
                { data: 'part_desc', name: 'part_desc' },
                { data: 'qty', name: 'qty' },
                { data: 'um', name: 'um' },
                { data: 'delete', name: 'delete' },

             ]
    });

		console.log(table);
 	});
}

//
$('.filter-items').click(function(){

	var table = $('table').DataTable();

	var mfr = $('#mfr').val();
	var partName = $('#part-name').val();

    table
    .columns( 0 )
    .search( mfr )
    .draw();


   table
    .columns( 1 )
    .search( partName )
    .draw();
})

//
supplierChange( '{{ $suppliers[0]->id }}' );

//
function supplierChange(value)
{
	$.ajax(
	{
	  url: "{{ URL::to('supplier/contact/get') }}/"+value
	})
	.done(function(data)
	{
	  $('.supplier-contact').html('');
	  $('.supplier-contact').html(data);
	});
}

//
function inquiryCustomer(value)
{
	$.ajax(
	{
	  url: "{{ URL::to('items/inquirycustomer/get') }}/"+value
	})
	.done(function(data)
	{
		var table = $('#table').DataTable();
		table.destroy();
		getItemTable( data.productIds, data.rfiId );
	});
}

//
function filterBy( value )
{
	if( value == 1 )
	{
		$('.filter').hide();
	}
	if( value == 2 )
	{
		$('.buttonFilter').show();
		$('.manufacturer').show();
		$('.partName').hide();
	}
	if( value == 3 )
	{
		$('.buttonFilter').show();
		$('.manufacturer').hide();
		$('.partName').show();
	}

	if( value == 4 )
	{
		$('.buttonFilter').show();
		$('.manufacturer').show();
		$('.partName').show();
	}
}

//
function deleteItemTemp( uIds )
{
	var table = $('#table').DataTable();
	var inqId = $('.inquiry-customer').val();
	table.destroy();
	getItemTable(uIds, inqId);
}
 </script>

@endsection
