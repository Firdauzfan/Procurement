@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">Create Inquiry</h3>
			</div>

		</div>
	</div>

	<div class="tab-content">
		<div class="tab-pane active" id="m_user_profile_tab_1">
			<form class="m-form m-form--fit m-form--label-align-right">

				<div class="col-6">
					<div class="form-group m-form__group row">
						<label for="example-text-input" class="col-4 col-form-label">Vendor</label>
						<div class="col-7">
							<input required="" class="form-control m-input" type="text">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="example-text-input" class="col-4 col-form-label">Inquiry Customer #</label>
						<div class="col-7">
							<input required="" class="form-control m-input" type="text">
						</div>
					</div>
					<div class="form-group m-form__group row">
						<label for="example-text-input" class="col-4 col-form-label">Vendor reference</label>
						<div class="col-7">
							<input required="" class="form-control m-input" type="text">
						</div>
					</div>
				</div>

				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions">
						<div class="row">
							<div class="col-12">
								<button type="reset" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save</button>&nbsp;&nbsp;
								<button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection
