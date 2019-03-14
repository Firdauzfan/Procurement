@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">Approve Quotation</h3>
			</div>
		</div>
		<div class="sub-heading">
			@if(session('success'))
			    {{session('success')}}
			@endif
		</div>
	</div>
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
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation Supplier Date</label>
							<div class="col-md-7">
								<input required="" name="qs_date" value="{{ $data->qs_date }}" class="date form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Request For Quote</label>
							<div class="col-md-7">
									@foreach( $rfq as $get )
										@if( $data->rfq_id == $get->id )
											<input required="" value="{{ $get->rfq_number }}" class="form-control" type="text">
											<input required="" name="rfq_id" value="{{ $get->id }}" class="form-control" type="text" hidden>
										@endif
									@endforeach
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
								}else if ($data->import_via == 1){
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

						<?php echo '<a href="#" type="button" onclick="qsnumber('.$data->id.')"> Show Data </a>';  ?>

					</div>




			</div>
	</div>
	<?php
  $dataid = $data->id;

	 ?>

	<div class="tab-content padding40px">
		<table class="table table-bordered" id="table">
           <thead>
              <tr>
                 <th>Quotation Number</th>
                 <th>Action</th>
                 <th>Reason</th>
              </tr>
           </thead>
        </table>
	</div>

  <!-- Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <form action="{{ route('quotation_approve_status') }}" method="post">
        <div class="modal-content">

          <div class="modal-body">
            {!! csrf_field() !!}
            <input type="hidden" name="id" class="id" value="">
            <input type="hidden" name="status" class="status" value="">
            <textarea class="form-control" name="reason" placeholder="Enter reason to reject"></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-warning" value="Reject">
          </div>
        </div>
      </form>

    </div>
  </div>

</div>
<link href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href='{{ asset("/css/jquery-ui.min.css") }}' />

<script type="text/javascript" src='{{ asset("/js/jquery-ui.min.js") }}'></script>
<script type="text/javascript" src='{{ asset("/js/jquery.dataTables.min.js") }}'></script>

<script type="text/javascript" src='{{ asset("/js/dataTables.bootstrap4.min.js") }}'></script>

<script type="text/javascript">
var dataid = "<?php echo $dataid ?>";
console.log(dataid)

$(function() {
               $('#table').DataTable({
               processing: "<img src='{{asset('build/img/jquery.easytree/loading.gif')}}'> Carregando...",
               serverSide: true,
               ajax: "{{ URL::to('quotation/approve/data/') }}/"+dataid,
               columns: [
                        { data: 'qs_num', name: 'qs_num' },
                        { data: 'action', name: 'action', searchable: 'false' },
                        { data: 'reason', name: 'reason', searchable: 'false' },

                     ]
            });
         });

function reject(id, status)
{
  $(".modal-body .id").val( id );
  $(".modal-body .status").val( status );
}
/*$(document).on("click", ".reject", function () {
     var myBookId = $(this).data('id');
     $(".modal-body #bookId").val( myBookId );
     // As pointed out in comments,
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});*/

 </script>
@endsection
