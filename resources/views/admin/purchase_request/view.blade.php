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

@endsection
