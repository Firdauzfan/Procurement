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
            <label for="example-text-input" class="col-md-3 col-form-label">PR #</label>
            <div class="col-md-7">
              <select required="" name="pr_number" class="form-control">
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
            <label for="example-text-input" class="col-md-3 col-form-label">Request From</label>
            <div class="col-md-7">
              <input required="" name="request_from" value="{{ $data->request_from }}" class="form-control m-input" type="text">
            </div>
          </div>
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Purpose</label>
            <div class="col-md-7">
              <input required="" name="purpose" value="{{ $data->purpose }}" class="form-control m-input" type="text">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Purchase Request Date</label>
            <div class="col-md-7">
              <input required="" name="pr_date" value="{{ $data->pr_date }}" class="date form-control m-input" type="text">
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Request Mode</label>
            <div class="col-md-7">
              <select required="" name="request_mode" class="form-control">
                <option <?php echo ( @$data->request_mode == 0 ? "selected=''" : '' ); ?> value="0">Routine</option>
                <option <?php echo ( @$data->request_mode == 1 ? "selected=''" : '' ); ?> value="1">Not Routine</option>
              </select>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Purpose Remark</label>
            <div class="col-md-7">
              <input required="" name="purpose_remark" value="{{ $data->purpose_remark }}" class="form-control m-input" type="text">
            </div>
          </div>
        </div>

        <input required="" type="hidden" value="{{ $data->id }}" name="id">

    </div>

</div>

<!-- RFQ Detail -->

<div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title ">Purchase Request Detail</h3>
    </div>
  </div>
</div>
<div class="tab-content padding40px shadowDiv">

    {!! csrf_field() !!}
    <div class="row" id="m_user_profile_tab_1">
        <div class="col-md-6">

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Request For Inquiry Id</label>
            <div class="col-md-7">
              <input required="" name="rfi_detail_id" value="{{ @$dataDetail->rfi_detail_id }}" class="form-control m-input" type="number">
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Sequence Number</label>
            <div class="col-md-7">
              <input required="" name="sequence_number" value="{{ @$dataDetail->sequence_number }}" class="form-control m-input" type="text">
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Type Product Id</label>
            <div class="col-md-7">
              <select required="" name="type_product_id" class="form-control">
                <option <?php echo ( @$dataDetail->type_product_id == 0 ? "selected=''" : '' ); ?> value="0">Buffer</option>
                <option <?php echo ( @$dataDetail->type_product_id == 1 ? "selected=''" : '' ); ?> value="1">Catalogue</option>
              </select>
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Product Id</label>
            <div class="col-md-7">
              <input required="" name="product_id" value="{{ @$dataDetail->product_id }}" class="form-control m-input" type="number">
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Qty RFQ</label>
            <div class="col-md-7">
              <input required="" name="qty_rfq" value="{{ @$dataDetail->qty_rfq }}" class="form-control m-input" type="text">
            </div>
          </div>

        </div>

        <div class="col-md-6">

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">UM RFQ</label>
            <div class="col-md-7">
              <input required="" name="um_rfq" value="{{ @$dataDetail->um_rfq }}" class="form-control m-input" type="text">
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Status</label>
            <div class="col-md-7">
              <input required="" name="rfq_detail_status" value="{{ @$dataDetail->status }}" class="form-control m-input" type="text">
            </div>
          </div>

          <div class="form-group m-form__group row">
            <label for="example-text-input" class="col-md-3 col-form-label">Validation Needed</label>
            <div class="col-md-7">
              <select required="" name="validation_needed" class="form-control">
                <option <?php echo ( @$dataDetail->validation_needed == 0 ? "selected=''" : '' ); ?> value="0">Yes</option>
                <option <?php echo ( @$dataDetail->validation_needed == 1 ? "selected=''" : '' ); ?> value="1">No</option>
              </select>
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

<!-- /RFQ Detail -->

</form>
</div>

@endsection
