@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">Approve Purchase Request</h3>
			</div>
		</div>
		<div class="sub-heading">
			@if(session('success'))
			    {{session('success')}}
			@endif
		</div>
	</div>
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


	<div class="tab-content padding40px">
		<table class="table table-bordered" id="table">
           <thead>
              <tr>
                 <th>Purchase Request Number</th>
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
      <form action="{{ route('purchase_request_approve_status') }}" method="post">
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

$(function() {
               $('#table').DataTable({
               processing: "<img src='{{asset('build/img/jquery.easytree/loading.gif')}}'> Carregando...",
               serverSide: true,
               ajax: "{{ route('purchase_request_approve_data') }}",
               columns: [
                        { data: 'pr_number', name: 'pr_number' },
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
