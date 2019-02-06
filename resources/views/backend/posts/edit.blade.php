@extends('layouts.master')
@section('title','Edit User')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Roles
        <small>Edit Role</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Roles</a></li>
        <li class="active">Edit Role</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              @component('alert')
              @endcomponent
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- form start -->
            {{ Form::model($role, array('route' => array('update-role', encrypt($role->id)), 'method' => 'PUT')) }}
              <div class="form-group">
                  {{ Form::label('name', 'Role Name') }}
                  {{ Form::text('name', null, array('class' => 'form-control')) }}
              </div>

              <h5><b>Assign Permissions</b></h5>
              @foreach ($permissions as $permission)
                  {{ Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
                  {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>  
              @endforeach
              <br>
              {{ Form::submit('Edit', array('class' => 'btn btn-primary')) }}

              {{ Form::close() }}
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
