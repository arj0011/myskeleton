@extends('layouts.master')
@section('title', 'Users')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small>User list</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">User list</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
              @component('alert')
              @endcomponent
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                {{ Form::open(array('url'=>'admin/users','id'=>'formFilter','method'=>'GET')) }}
                <div class="col-sm-1">
                  <input class="form-control input-sm" onkeydown="return false" autocomplete="off" name="startDate" value="{{ Request::query('startDate') }}" id="startDate" type="text" placeholder="Start Date">
                </div>
                <div class="col-sm-1">
                  <input class="form-control input-sm" onkeydown="return false" autocomplete="off" name="endDate" value="{{ Request::query('endDate') }}" id="endDate" type="text" placeholder="End Date">
                </div>
                <div class="col-sm-1">
                  <select name="status" class="form-control input-sm">
                    <option value="">Status</option>
                    <option value="1" {{ (Request::query('status') == '1') ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ (Request::query('status') == '0') ? 'selected' : ''}}>Deactive</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  <button type="submit" id="filter_data"  class="btn btn-sm btn-primary">Filter</button>&nbsp;&nbsp;
                  <button type="button" id="reset_filter" class="btn btn-sm btn-default">Reset</button>
                </div>
                {{ Form::close() }}
                @can('Export User')
                <a href="javascript:void(0);" id="export_excel" data-type="xls" class="exportreport btn btn-default">Export Excel</a>
                <a href="javascript:void(0);" id="export_csv" data-type="csv" class="exportreport btn btn-default">Export CSV</a>
                @endcan
                @can('Import User')
                <a href="javascript:void(0);" id="import_excel" class="importreport btn btn-default">Import Users</a>
                <a href="javascript:void(0);" id="download_format" class="btn btn-default">Download Format</a>
                @endcan
                @can('Create User')
                <a href="{{ url("admin/create-user") }}" id="create_user" class="btn btn-primary">Create Users</a>
                @endcan
              </div>
              @can('Delete User')
              <br />
              <button style="" class="btn btn-danger delete_all">Delete All Selected</button>
              @endcan
              <br />
              
              {!! $dataTable->table([], true) !!}

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<!-- /.modal -->
  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">User Details</h4>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
  
<!-- /.modal -->
  <div class="modal fade" id="modal-import">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Import Users</h4>
        </div>
        <div class="modal-body">
          {{ Form::open(array('url'=>'admin/users-import','method'=>'POST','id'=>'formImport','files'=> true)) }}
            <div class="form-group">
              <input type="file" class="form-control" name="import_file" id="importfile" />  
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Import Users</button>
          {{ Form::close() }}
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->




  <!-- /.content-wrapper -->
@endsection  

@push('style')
<link rel="stylesheet" href="{{ asset('public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
@endpush

@push('scripts')
<!-- bootstrap datepicker -->
<script src="{{ asset('public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('public/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<!-- datatable btn script -->
{{-- <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script> --}}
<!-- datatable btn script -->

{!! $dataTable->scripts() !!}

<script>
$(document).ready(function(){
  
  //Filter Records  
  $(document).on('click','#filter_data',function(){
    start_data = $('#startDate').val();
    end_data = $('#endDate').val();
    if(end_data != '' && start_data == ''){
      swal("Error!","Start date required", "error");
      return false;
    }
    
    $('#filter_data').submit();
  });
  
  //Reset filter
  $(document).on('click','#reset_filter',function(){
    window.location.href= '{{ url('admin/users') }}';
  });

  //Import Excel Records
  $(document).on('click','#import_excel',function(){
    $('#modal-import').modal('show');
  });

  $(document).on('click','#download_format',function(){
    url = '{{ url("admin/users-format") }}';
    window.location = url;
  });

  //for export to excel/csv
  $('.exportreport').click(function () {
    type = $(this).data('type');
    var param_str = $('#formFilter').serialize();
    param_str+=param_str+'&type='+type;  
    url = '{{ url("admin/users-export") }}'+'?'+param_str;
    window.location = url;
  });

  // View User
  $(document).on('click','.viewUser',function(){
    user_id = $(this).data('user_id');
    $.ajax({
        "headers":{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        type:"POST",
        data:{"user_id":user_id},
        url :'{{ url("admin/viewUser") }}',
        success : function(response){
          if(response.status){
            $('.modal-body').html(response.html);
            $('#modal-default').modal('show');
          }else{
            swal("Error!", response.message, "error");
          }
        }
      });
  });
  
  // Delete User
  $(document).on('click','.deleteUser',function(){
    user_id = $(this).data('user_id');
    swal({
      title: "Are you sure?",
      text: "Your will not be able to recover this user!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function(){
      $.ajax({
        "headers":{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        type:"POST",
        data:{"user_id":user_id},
        url :'{{ url("admin/deleteUser") }}',
        success : function(response){
          if(response.status){
            swal("Deleted!", "User has been deleted.", "success");
            $('#dataTableBuilder').DataTable().draw(false);
          }else{
            swal("Error deleting!", "Please try again", "error");
          }
        }
      });
    });
  });
});

$('#dataTablesCheckbox').on('click', function(e) {
  if($(this).is(':checked',true)){
    $(".sub_chk").prop('checked', true);  
  } else {  
    $(".sub_chk").prop('checked',false);  
  }   
});

$(document).on('click','.delete_all', function() {
  var allVals = [];  
  $(".sub_chk:checked").each(function() {  
      allVals.push($(this).attr('data-id'));
  });  

  if(allVals.length <=0)  
  {  
    swal("Error deleting!", "Please select row.", "error");
  } else {  
    
    swal({
      title: "Are you sure?",
      text: "Your will not be able to recover this users!",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    },
    function(){
      var join_selected_values = allVals.join(",");
      $.ajax({
        "headers":{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        type:"POST",
        data: 'ids='+join_selected_values,
        url :'{{ route("deleteAllUser") }}',
        success: function (data) {
          if(data.status) {
            $(".sub_chk:checked").each(function() {  
              swal("Deleted!", data.message, "success");
              // $(this).parents("tr").remove();
              $('#dataTableBuilder').DataTable().draw(false);
            });
          }else {
            swal("Error!", "Whoops Something went wrong!!", "warning");
          }
        }
      });

      // $.each(allVals, function( index, value ) {
      //   $('table tr').filter("[data-row-id='" + value + "']").remove();
      // });
    });        
  }  
});


//Datepicker with date validation
$('#startDate').datepicker({autoclose:true,format: 'yyyy-mm-dd',keyboardNavigation:false,minDate:new Date()
}).change(function(){
    if($('#endDate').val() != '' && $('#endDate').val() != undefined){
      var first =  $(this).val();
      var second =  $('#endDate').val();
      if(new Date(second).getTime() <= new Date(first).getTime()){
        swal("Error!","Start date should be less than end date", "error");
        $(this).val('');
        $("#acc").html('');
      }
    }
});
$('#endDate').datepicker({autoclose:true,format: 'yyyy-mm-dd',keyboardNavigation:false,minDate:new Date()
}).change(function(){
    if($('#startDate').val() != '' && $('#startDate').val() != undefined){
      var first = $('#startDate').val();
      var second = $(this).val();
      if(new Date(first).getTime() >= new Date(second).getTime()){
        swal("Error!","End date should be greater than start date", "error");
        $(this).val('');
        $("#acc").html(''); 
      }
    } 
});

//get param from query string
function getUrlParam(param_str){
  queryArr = param_str.replace('?','').split('&'),        
  queryParams = [];
  for (var q = 0, qArrLength = queryArr.length; q < qArrLength; q++) {
      var qArr = queryArr[q].split('=');
      queryParams[qArr[0]] = qArr[1];
  }
  return queryParams;
}

</script>

@endpush