@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
<div class="m-subheader ">
  <div class="d-flex align-items-center">
    <div class="mr-auto">
      <h3 class="m-subheader__title ">Purchase Request List</h3>
      <a href="{{ route('create_purchase_request') }}" class="btn btn-accent m-btn m-btn--air m-btn--custom">Create</a>
    </div>
  </div>
  <div class="sub-heading">
    @if(session('success'))
        {{session('success')}}
    @endif
  </div>
</div>

<div class="tab-content padding40px">
  <table class="table table-bordered" id="table">
         <thead>
            <tr>
               <th>Purchase Request Number</th>
               <th>Approved status</th>
               <th>Approved by</th>
               <th>Request From</th>
               <th>Request Mode</th>
               <th>Purpose</th>
               <th>Purpose Remark</th>
               <th>Purchase Request Date</th>
               <th>Action</th>
            </tr>
         </thead>
      </table>
</div>
</div>
<link href="https://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href='{{ asset("/css/jquery-ui.min.css") }}' />

<script type="text/javascript" src='{{ asset("/js/jquery-ui.min.js") }}'></script>
<script type="text/javascript" src='{{ asset("/js/jquery.dataTables.min.js") }}'></script>

<script type="text/javascript" src='{{ asset("/js/dataTables.bootstrap4.min.js") }}'></script>

<script type="text/javascript">

$(function() {
             $('#table').DataTable({
             processing: true,
             serverSide: true,
             ajax: "{{ route('purchase_request_data') }}",
             columns: [
                      { data: 'pr_number', name: 'pr_number'},
                      { data: 'approved', name: 'approved' },
                      { data: 'approved_by', name: 'approved_by' },                      
                      { data: 'request_from', name: 'request_from' },
                      { data: 'request_mode', name: 'request_mode' },
                      { data: 'purpose', name: 'purpose' },
                      { data: 'purpose_remark', name: 'purpose_remark' },
                      { data: 'pr_date', name: 'pr_date' },
                      { data: 'action', name: 'action', searchable: 'false' },

                   ]
          });
       });

</script>
@endsection
