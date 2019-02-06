@extends('layouts.master')
@section('title','Edit User')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Roles
        <small>Create Role</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Roles</a></li>
        <li class="active">Create Role</li>
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
            {{ Form::open(array('url' => 'admin/store-role')) }}

              <div class="form-group">
                  {{ Form::label('name', 'Name') }}
                  {{ Form::text('name', null, array('class' => 'form-control')) }}
              </div>

              <h5><b>Assign Permissions</b></h5>

              <div class='form-group'>
                  @foreach ($permissions as $permission)
                      {{ Form::checkbox('permissions[]',  $permission->id ) }}
                      {{ Form::label($permission->name, ucfirst($permission->name)) }}<br>
                  @endforeach
              </div>

              {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}

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
