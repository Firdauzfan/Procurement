	@extends('layouts.admin')

@section('content')
<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">Quotation Supplier List</h3>
        <a href="{{ route('create_quotation') }}" class="btn btn-accent m-btn m-btn--air m-btn--custom">Create</a>
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
                 <th>Quotation Supplier Number</th>
								 <th>Approved status</th>
								 <th>Approved by</th>
                 <th>Supplier</th>
                 <th>Supplier Contact</th>
                 <th>Shipment Term</th>
                 <th>Import Via</th>
                 <th>Cost Freight</th>
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
               ajax: "{{ route('quotation_data') }}",
               columns: [
                        { data: 'qs_num', name: 'qs_num', searchable: 'false' },
												{ data: 'approved', name: 'approved' },
												{ data: 'approved_by', name: 'approved_by' },
                        { data: 'supplier_id', name: 'supplier_id' },
                        { data: 'supplier_contact_id', name: 'supplier_contact_id' },
                        { data: 'shipment_term', name: 'shipment_term' },
                        { data: 'import_via', name: 'import_via' },
                        { data: 'cost_freight', name: 'cost_freight' },
                        { data: 'action', name: 'action', searchable: 'false' },

                     ]
            });
         });

 </script>
@endsection
