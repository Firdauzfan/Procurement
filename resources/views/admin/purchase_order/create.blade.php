	@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">Create Purchase Order</h3>
			</div>
		</div>
	</div>
	<form action="{{ route('save_purchase_order') }}" method="post" enctype="multipart/form-data">
	<div class="tab-content padding40px shadowDiv">

			{!! csrf_field() !!}
			<div class="row" id="m_user_profile_tab_1">
					<div class="col-md-6">
						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Purchase Order</label>
							<div class="col-md-7">
								<input required="" required="" name="po_number" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Purchase Request</label>
							<div class="col-md-7">
								<select required="" name="pr_id" class="form-control">
									@foreach( $data as $get )
										<option value="{{ $get->id }}">{{ $get->pr_id }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Request For Quote</label>
							<div class="col-md-7">
								<select required="" name="rfq_id" class="form-control">
									@foreach( $rfq as $get )
										<option value="{{ $get->id }}">{{ $get->id }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Supplier</label>
							<div class="col-md-7">
								<select required="" name="supplier_id" class="form-control">
									@foreach( $suppliers as $get )
										<option value="{{ $get->id }}">{{ $get->supplier_name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Supplier Contact</label>
							<div class="col-md-7">
								<select required="" name="supplier_contact_id" class="form-control">
									@foreach( $supplierContacts as $get )
										<option value="{{ $get->id }}">{{ $get->contact_name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Shipment Term</label>
							<div class="col-md-7">
								<input required="" required="" name="shipment_term" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Payment Term</label>
							<div class="col-md-7">
								<input required="" required="" name="payment_term" class="form-control m-input" type="text">
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
								<input required="" required="" name="cost_freight_amount" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">VAT</label>
							<div class="col-md-7">
								<input required="" required="" name="vat" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Quotation S Rating</label>
							<div class="col-md-7">
								<input required="" required="" name="qs_rating" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Remark</label>
							<div class="col-md-7">
								<input required="" required="" name="remark" class="form-control m-input" type="text">
							</div>
						</div>

					</div>

					<div class="col-md-6">

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Attached File</label>
							<div class="col-md-7">
								<input required="" required="" name="attached_file" class="form-control m-input file-input" type="file">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Status</label>
							<div class="col-md-7">
								<input required="" required="" name="status" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Invoice Status</label>
							<div class="col-md-7">
								<select required="" name="invoice_status" class="form-control">
									<option value="0">Not Billed</option>
									<option value="1">Partially Billed</option>
									<option value="2">Fully Billed</option>
								</select>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">PO Supplier Rating</label>
							<div class="col-md-7">
								<input required="" required="" name="pos_supplier_rating" class="form-control m-input" type="text">
							</div>
						</div>

						<!-- <div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Tax %</label>
							<div class="col-md-7">
								<input required="" required="" name="tax" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Discount %</label>
							<div class="col-md-7">
								<input required="" required="" name="discount" class="form-control m-input" type="text">
							</div>
						</div>

						<div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Remark</label>
							<div class="col-md-7">
								<input required="" required="" name="remark" class="form-control m-input" type="text">
							</div>
						</div> -->

						<div class="form-group m-form__group row">
							<!-- <label for="example-text-input" class="col-md-3 col-form-label">Approved</label> -->
							<div class="col-md-7">
								<input name="approved" class="custom-checkbox m-input" value="0" hidden>
							</div>
						</div>

						<div class="form-group m-form__group row">
							<!-- <label for="example-text-input" class="col-md-3 col-form-label">Approved By</label> -->
							<div class="col-md-7">
								<input required="" value=" " name="approved_by" class="form-control m-input" type="text" hidden>
							</div>
						</div>

						<!-- <div class="form-group m-form__group row">
							<label for="example-text-input" class="col-md-3 col-form-label">Approved Date</label>
							<div class="col-md-7">
								<input required="" required="" name="approved_date" class="form-control m-input date" type="text">
							</div>
						</div> -->

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
	</div>
	</form>
</div>

@endsection
