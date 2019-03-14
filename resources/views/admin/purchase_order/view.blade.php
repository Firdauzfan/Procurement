	@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">View/Update Purchase Order</h3>
			</div>
		</div>
	</div>
	<form action="{{ route('update_purchase_order') }}" method="post" enctype="multipart/form-data">
	<div class="tab-content padding40px shadowDiv">

			{!! csrf_field() !!}
			<div class="row" id="m_user_profile_tab_1">
					<div class="col-md-6">
						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Purchase Order</label>
							<div class="col-md-7">
								<input required="" type="hidden" value="{{ $data->id }}" name="id">
								<select required="" name="po_number" class="form-control" onchange="location = this.value;">
									@foreach( $dataall as $get )
										@if( $get->po_number == $data->po_number)
											<option value="{{ $data->po_number }}" selected=""> {{ $data->po_number }}</option>
										@else
											<option value="{{ $get->id }}"> {{ $get->po_number }}</option>
										@endif
									@endforeach
								</select>
								<!-- <input required="" required="" name="pr_id" value="{{ $data->pr_id }}" class="form-control m-input" type="text"> -->
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Purchase Request</label>
							<div class="col-md-7">
								<input required="" type="hidden" value="{{ $data->id }}" name="id">
								<select required="" name="pr_id" class="form-control">
									@foreach( $dataall as $get )
										@if( $get->pr_id == $data->pr_id)
											<option value="{{ $data->pr_id }}" selected=""> {{ $data->pr_id }}</option>
										@else
											<option value="{{ $get->id }}"> {{ $get->pr_id }}</option>
										@endif
									@endforeach
								</select>
								<!-- <input required="" required="" name="pr_id" value="{{ $data->pr_id }}" class="form-control m-input" type="text"> -->
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Request For Quote</label>
							<div class="col-md-7">
								<select required="" name="rfq_id" class="form-control">
									@foreach( $rfq as $get )
										@if( $get->id == $data->rfq_id )
											<option value="{{ $get->id }}">{{ $get->id }}</option>
										@else
											<option value="{{ $get->id }}" selected="">{{ $get->id }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Supplier</label>
							<div class="col-md-7">
								<select required="" name="supplier_id" class="form-control">
									@foreach( $suppliers as $get )
										@if( $get->id == $data->supplier_id )
											<option value="{{ $get->id }}" selected="">{{ $get->supplier_name }}</option>
										@else
											<option value="{{ $get->id }}">{{ $get->supplier_name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Supplier Contact</label>
							<div class="col-md-7">
								<select required="" name="supplier_contact_id" class="form-control">
									@foreach( $supplierContacts as $get )
										@if( $get->id == $data->supplier_contact_id )
											<option value="{{ $get->id }}" selected="">{{ $get->contact_name }}</option>
										@else
											<option value="{{ $get->id }}">{{ $get->contact_name }}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Shipment Term</label>
							<div class="col-md-7">
								<input required="" required="" name="shipment_term" value="{{ $data->shipment_term }}" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Payment Term</label>
							<div class="col-md-7">
								<input required="" required="" name="payment_term" value="{{ $data->payment_term }}" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Import Via</label>
							<div class="col-md-7">
								<select required="" name="import_via" class="form-control">
									<option <?php echo ( $data->import_via == 0 ? "selected=''" : '' ); ?> value="0">Local</option>
									<option <?php echo ( $data->import_via == 1 ? "selected=''" : '' ); ?> value="1">Air</option>
									<option <?php echo ( $data->import_via == 2 ? "selected=''" : '' ); ?> value="2">Sea</option>
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Cost Freight</label>
							<div class="col-md-7">
								<select required="" name="cost_freight" class="form-control">
									<option <?php echo ( $data->cost_freight == 0 ? "selected=''" : '' ); ?> value="0">Paid</option>
									<option <?php echo ( $data->cost_freight == 1 ? "selected=''" : '' ); ?> value="1">Not Paid</option>
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Cost Freight Amount</label>
							<div class="col-md-7">
								<input required="" required="" name="cost_freight_amount" value="{{ $data->cost_freight_amount }}" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">VAT</label>
							<div class="col-md-7">
								<input required="" required="" name="vat" value="{{ $data->vat }}" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation S Rating</label>
							<div class="col-md-7">
								<input required="" required="" name="qs_rating" value="{{ $data->qs_rating }}" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Remark</label>
							<div class="col-md-7">
								<input required="" required="" name="remark" value="{{ $data->remark }}" class="form-control m-input" type="text">
							</div>
						</div>

					</div>

					<div class="col-md-6">

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Attached File</label>
							<div class="col-md-7">
								<input name="attached_file" value="{{ $data->attached_file }}" class="form-control m-input file-input" type="file">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Status</label>
							<div class="col-md-7">
								<input required="" required="" name="status" value="{{ $data->status }}" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Invoice Status</label>
							<div class="col-md-7">
								<select required="" name="invoice_status" class="form-control">
									<option <?php echo ( $data->invoice_status == 0 ? "selected=''" : '' ); ?> value="0">Not Billed</option>
									<option <?php echo ( $data->invoice_status == 1 ? "selected=''" : '' ); ?> value="1">Partially Billed</option>
									<option <?php echo ( $data->invoice_status == 2 ? "selected=''" : '' ); ?> value="2">Fully Billed</option>
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">PO Supplier Rating</label>
							<div class="col-md-7">
								<input required="" required="" name="pos_supplier_rating" value="{{ $data->pos_supplier_rating }}" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<!-- <label for="example-text-input" class="col-md-3 col-form-label">Approved</label> -->
							<div class="col-md-7">
								<input name="approved" <?php echo $data->approved ? "checked" : ""; ?> class="custom-checkbox m-input" value=1 type="checkbox" hidden>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<!-- <label for="example-text-input" class="col-md-3 col-form-label">Approved By</label> -->
							<div class="col-md-7">
								<input required="" required="" name="approved_by" value="{{ $data->approved_by }}" class="form-control m-input" type="text" hidden>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<!-- <label for="example-text-input" class="col-md-3 col-form-label">Approved Date</label> -->
							<div class="col-md-7">
								<input required="" required="" name="approved_date" value="{{ $data->approved_date }}" class="form-control m-input date" type="text" hidden>
							</div>
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
	</form>
</div>

@endsection
